<?php

namespace App\Models;

use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard_name = 'admin';

    protected $table = 'admins';

    protected $guarded = [];

    protected $fillable = [
        'name', 'email', 'password', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        if (trim($password) === '') {
            return;
        }
        $this->attributes['password'] = Hash::make($password);
    }

    public function getEncryptedIdAttribute()
    {
        return encrypt_param($this->id);
    }
}
