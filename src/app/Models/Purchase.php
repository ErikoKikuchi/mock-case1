<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable=[
        'buyer_user_id',
        'seller_user_id', 
        'product_id',
        'payment_method',
        'shipping_address_id',
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
    public function shippingAddresses()
    {
        return $this->belongsTo(ShippingAddress::class);
    }
}
