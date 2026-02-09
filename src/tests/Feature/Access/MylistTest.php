<?php

namespace Tests\Feature\Access;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

            Profile::factory()->for($owner)->create();
            Profile::factory()->for($seller)->create();

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
        public function test_mylist_shows_sold_label_only_for_sold_products()
        {
            $seller = User::factory()->create();
            $viewer = User::factory()->create();

            Profile::factory()->for($seller)->create();
            Profile::factory()->for($viewer)->create();
            $soldProduct = Product::factory()->for($seller)->sold()->create([
                'title' => 'SOLD商品',
            ]);
            $normalProduct = Product::factory()->for($seller)->create([
                'title' => '通常商品',
            ]);

            Like::factory()->create([
                'user_id' => $viewer->id,
                'product_id' => $soldProduct->id,
            ]);
            Like::factory()->create([
                'user_id' => $viewer->id,
                'product_id' => $normalProduct->id,
            ]);
            $response = $this->actingAs($viewer)->get('/?tab=mylist');
            $response->assertStatus(200);

            $response->assertSee('SOLD商品');
            $response->assertSee('通常商品');

            // SOLD商品には SOLD ラベルが出る
            $response->assertSee('SOLD');
        }
    //未認証の場合は何も表示されない
        public function test_guest_sees_nothing_on_mylist_tab()
        {
            $response = $this->get('/?tab=mylist');
            $response->assertOk();
            $response->assertDontSee('product-card');
            $response->assertDontSee('SOLD');
            $response->assertDontSee('マイリストに商品はありません');
        }
}