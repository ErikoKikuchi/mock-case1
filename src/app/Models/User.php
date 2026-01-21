<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

//他のテーブルとの関係
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->belongsToMany(Product::class, 'likes', 'user_id', 'product_id');
    }
    public function purchasesAsBuyer()
    {
        return $this->hasMany(Purchase::class, 'buyer_user_id');
    }
    public function purchasesAsSeller()
    {
        return $this->hasMany(Purchase::class, 'seller_user_id');
    }
//以下ロジック系
    //プロフィール完成しているか
    public function canViewProductList():bool
    {
        return $this->profile?->isComplete()===true;
    }
    //いいねONOFF
    public function toggleLike(int $productId):bool
    {
        $result= $this->likes()->toggle($productId);
        return !empty($result['attached']);
    }
    //いいねがされているか
    public function hasLiked(int $productId): bool
    {
    return $this->likes()
        ->where('product_id', $productId)
        ->exists();
    }
    //購入したか
    public function hasPurchased(Product $product):bool
    {
        return $this->purchases()
            ->where('product_id',$product->id)
            ->exists();
    }
    //出品者かどうか
    public function isSellerOf(Product $product):bool
    {
        return $product->user_id===$this->id;
    }
}
