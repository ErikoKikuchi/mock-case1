<?php

namespace Tests\Feature\Access;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;

class IndexTest extends TestCase
{
    use RefreshDatabase;

//全商品を取得できる(guest)
    public function test_guest_can_see_all_products_on_index()
    {
        $owner = User::factory()->create();
        $products = Product::factory()->count(3)->for($owner)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($products as $product) {
        $response->assertSee($product->title);
        $response->assertSee('/storage/products/', false);
        }
    }

//購入済み商品は「Sold」と表示される
    public function test_index_shows_sold_label_only_for_sold_products()
    {
        $owner = User::factory()->create();
        $soldProduct = Product::factory()->for($owner)->sold()->create([
            'title' => 'SOLD商品',
        ]);

        $other = User::factory()->create();
        $normalProduct = Product::factory()->for($other)->create([
            'title' => '通常商品',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee('SOLD商品');
        $response->assertSee('通常商品');

        // SOLD商品には SOLD ラベルが出る
        $response->assertSee('SOLD');
    }

//自分が出品した商品は表示されない
    public function test_logged_in_user_does_not_see_own_products()
    {
        $user = User::factory()->create();
        Profile::factory()->for($user)->create();
        Product::factory()->for($user)->create(['title' => '自分の商品']);

        $other = User::factory()->create();
        Product::factory()->for($other)->create(['title' => '他人の商品']);

        $response = $this->actingAs($user)->get('/');

        $response->assertSee('他人の商品');
        $response->assertDontSee('自分の商品');
    }
}