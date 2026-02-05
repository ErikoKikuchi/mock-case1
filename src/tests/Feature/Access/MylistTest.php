<?php

namespace Tests\Feature\Access;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use App\Models\Product;
use App\Models\Profile;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    //いいねした商品だけが表示される
        public function test_user_can_see_liked_products_on_mylist()
        {
            $owner = User::factory()->create();
            $seller = User::factory()->create();

            Profile::factory()->for($owner)->create([
            'user_id' => $owner->id,
            'name' => 'テスト1',
            'post_code' => '1234567',
            'address' => '東京都渋谷区',
            ]);
            Profile::factory()->for($seller)->create([
            'user_id' => $seller->id,
            'name' => 'テスト2',
            'post_code' => '1234123',
            'address' => '東京都渋谷区',
            ]);

            $liked = Product::factory()->for($seller)->create(['title' => 'いいねした商品']);
            $notLiked = Product::factory()->for($seller)->create(['title' => 'いいねしてない商品']);


            Like::factory()->create([
                'user_id' => $owner->id,
                'product_id' => $liked->id,
            ]);

            $response = $this->actingAs($owner)->get('/?tab=mylist');

            $response->assertSee('いいねした商品');
            $response->assertDontSee('いいねしてない商品');
        }
    //購入済み商品は「Sold」と表示される

    //未認証の場合は何も表示されない
}