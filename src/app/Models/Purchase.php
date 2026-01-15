<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable=[
        'buyer_user_id',
        'product_id',
        'post_code',
        'address',
        'payment_method',
        'status'
    ];

//他テーブルとの関係
    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_user_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_user_id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
