<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name'];

//他テーブルとの関係
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
