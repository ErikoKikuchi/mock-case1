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
        'price',
        'user_id',
        'condition'
    ];
//コンディション選択肢
    const CONDITION_GOOD = 1;
    const CONDITION_FINE = 2;
    const CONDITION_FAIR = 3;
    const CONDITION_BAD = 4;

    public static function conditions()
    {
        return [
            self::CONDITION_GOOD => '良好',
            self::CONDITION_FINE => '目立った傷や汚れなし',
            self::CONDITION_FAIR => 'やや傷や汚れあり',
            self::CONDITION_BAD => '状態が悪い',
        ];
    }

//他テーブルとの関係
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
    public function likes()
    {
        return $this->belongsToMany(User::class,'likes','product_id', 'user_id')->withTimestamps();
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
        return $this->hasMany(Purchase::class);
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
