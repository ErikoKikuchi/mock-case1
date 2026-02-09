<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingAddress extends Model
{
    use HasFactory;
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
