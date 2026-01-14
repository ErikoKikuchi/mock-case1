<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable=['name'];

//他テーブルとの関係
    public function products()
    {
        return $this->hasMany(Product::class)->withTimestamps();
    }
}
