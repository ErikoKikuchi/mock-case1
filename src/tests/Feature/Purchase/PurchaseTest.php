<?php

namespace Tests\Feature\Purchase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

//「購入する」ボタンを押下すると購入が完了する
    public function test_login_user_can_purchase_product()
    {
        $seller = User::factory()->create();
        $product = Product::factory()->for($seller)->create();

        $buyer = User::factory()->create();
        $profile =Profile::factory()->for($buyer)->create();

        $this->assertDatabaseCount('purchases', 0);

        $response = $this->actingAs($buyer)->post(route('purchase.store'), [
            'payment_method' => 'card',
            'product_id' => $product->id]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('purchases', [
        'buyer_user_id' => $buyer->id,
        'product_id' => $product->id,
        'shipping_address_id' => null,
        'shipping_post_code' => $profile->post_code,
        'shipping_address' => $profile->address,
        'shipping_building' => $profile->building,
        'payment_method' => 'card',
        'status' => 'pending',
        ]);
    }

//購入した商品は商品一覧画面にて「sold」と表示される
    public function test_purchase_product_has_sold_label_at_index()
    {
        $seller = User::factory()->create();
        $product = Product::factory()->for($seller)->create();

        $buyer = User::factory()->create();
        Profile::factory()->for($buyer)->create();

        $this->assertDatabaseCount('purchases', 0);

        $response = $this->actingAs($buyer)->post(route('purchase.store'), [
            'payment_method' => 'card',
            'product_id' => $product->id]);

        $response->assertRedirect(route('home'));

        $response = $this->get(route('home'));
        $response->assertOk();

        $response->assertSee('SOLD');
    }

//「プロフィール/購入した商品一覧」に追加されている
    public function test_purchase_product_can_see_at_mypage_has_purchased_tab()
    {
        $seller = User::factory()->create();
        $product = Product::factory()->for($seller)->create(['title'=>'テスト商品']);

        $buyer = User::factory()->create();
        Profile::factory()->for($buyer)->create();

        $this->assertDatabaseCount('purchases', 0);

        $response = $this->actingAs($buyer)->post(route('purchase.store'), [
            'payment_method' => 'card',
            'product_id' => $product->id]);

        $response->assertRedirect(route('home'));

        $response = $this->actingAs($buyer)->get(route('mypage', ['tab' => 'hasPurchased']));
        $response->assertOk();

        $response->assertSee('テスト商品');
    }
}