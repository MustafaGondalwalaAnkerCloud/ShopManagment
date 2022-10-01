<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function category(){
        return $this->hasOne(Category::class,'category_id');
    }
    
    public function subCategory(){
        return $this->hasOne(Category::class,'sub_category_id');
    }
}
