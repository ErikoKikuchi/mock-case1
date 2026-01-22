<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable=[
        'post_code',
        'address',
        'building',
        'user_id',
        'product_id'
    ];
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
