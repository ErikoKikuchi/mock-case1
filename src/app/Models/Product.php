<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'title',
        'image',
        'brand',
        'description',
        'price'
    ];

//他テーブルとの関係
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
    public function likes()
    {
        return $this->belongsToMany(User::class,'likes','product_id', 'user_id')->withTimestamps();
    }
    public function conditions()
    {
        return $this->belongsTo(Condition::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->belongsToMany(Comment::class,'comments', 'product_id', 'user_id')->withPivot('body')->withTimestamps();
    }
    public function purchases()
    {
        return $this->hasMany(Purchases::class);
    }
//ロジック系
    //いいね数
    public function likesCount():int
    {
        return $this->likes()->count();
    }
    //売り切れかどうか
    public function isSold():bool
    {
        return $this->purchases()->where('status', 'completed')->exists();
    }
}
