<?php

namespace Tests\Feature\Information;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\ShippingAddress;
use App\Models\Purchase;
use Illuminate\Support\Facades\Storage;

class UserTest extends TestCase
{
    use RefreshDatabase;

//必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
    public function test_user_can_see_profile_page()
    {
        $seller = User::factory()->create();
        $product=Product::factory()->for($seller)->create([
                    'title' => '購入商品',
                ]);

        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();
        $normalProduct = Product::factory()->for($user)->create([
                    'title' => '出品商品',
                ]);

        Purchase::factory()->create([
            'buyer_user_id'       => $user->id,
            'seller_user_id'      => $seller->id,
            'product_id'          => $product->id,
            'status'              => 'pending',
            'shipping_address_id' => null,
            'shipping_post_code' => $profile->post_code,
            'shipping_address' => $profile->address,
            'shipping_building' => $profile->building,
            'payment_method' => 'card',
            ]);

        $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'hasPurchased']));

        $response->assertSee('/storage/profiles/', false);
        $response->assertSee($profile->name);
        $response->assertSee('購入商品');

        $response = $this->actingAs($user)->get(route('mypage', ['tab' => 'isSellerOf']));
        $response->assertSee('出品商品');
    }
}