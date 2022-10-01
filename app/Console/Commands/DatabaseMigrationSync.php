<?php

namespace App\Console\Commands;

use App\External\MigrateSync\Schema;
use File;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as LaravelSchema;
use Spatie\Regex\Regex;

class DatabaseMigrationSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Developer migrations syncing tool';

    protected $schemas;

    /**
     * Create a new migration command instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator  $migrator
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->schemas = Collection::make();
    }

    public function handle()
    {
        $files = File::allFiles('database/migrations');

        foreach ($files as $file) {
            $this->processMigration(file_get_contents($file));
        }

        $this->abondedTables()->each(function ($table) {
            $this->error("Schemas doesn't have table <fg=black;bg=white> {$table} </> seems you have delete it");

            $this->confirm(
                "Do you want to drop <fg=black;bg=white> {$table} </> ?",
                true
            ) && LaravelSchema::dropIfExists($table);
        })->isEmpty() && $this->syncedOrNot();
    }

    protected function syncedOrNot()
    {
        return ! $this->schemas->pluck('synced')->contains(true) && $this->info('Nothing to sync.');
    }

    protected function tables()
    {
        return Collection::make(DB::select('SHOW TABLES'))->map(function ($table) {
            return array_values((array) $table);
        })->flatten();
    }

    protected function processMigration($content)
    {
        $schemas = $this->getAllSchemas($content);

        foreach ($schemas as $schema) {
            $schema = new Schema($schema, $this);
            $schema->process();
            $this->schemas->push($schema);
        }
    }

    protected function getAllSchemas($content)
    {
        return Regex::matchAll('/Schema::create\s*\((.*)\,.*{(.*)}\);/sU', $content)->results();
    }

    /**
     * @return mixed
     */
    protected function abondedTables()
    {
        return $this->tables()->diff($this->schemasTables());
    }

    protected function schemasTables()
    {
        return $this->schemas->pluck('name')->push('migrations')->map(function ($name) {
            return DB::getTablePrefix().$name;
        });
    }
}
