<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name'];

//他テーブルとの関係
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
