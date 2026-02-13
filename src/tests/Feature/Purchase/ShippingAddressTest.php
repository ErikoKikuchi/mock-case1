<?php

namespace Tests\Feature\Purchase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\ShippingAddress;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;

//送付先住所変更画面にて登録した住所が商品購入画面に反映されている
    public function test_buyer_shipping_address_is_reflected_on_purchase_page()
    {
        $seller = User::factory()->create();
        $product = Product::factory()->for($seller)->create();

        $buyer = User::factory()->create();
        Profile::factory()->for($buyer)->create();

        $this->assertDatabaseCount('shipping_addresses', 0);
        $address =[
            'post_code' => '123-4567',
            'address'=>'東京都',
            'building'=>'テストマンション3階',
        ];
        $response = $this->actingAs($buyer) ->followingRedirects()->patch(route('create.shipping-address', ['item_id' => $product->id]),$address);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('shipping_addresses', [
            'user_id'=>$buyer->id,
            'post_code' => '123-4567',
            'address'=>'東京都',
            'building'=>'テストマンション3階'
        ]);
        $response->assertOk();
        $response->assertSee('配送先');
        $response->assertSee('123-4567');
        $response->assertSee('東京都');
        $response->assertSee('テストマンション3階');
    }

//購入した商品に送付先住所が紐づいて登録される
    public function test_buyer_shipping_address_is_reflected_on_purchased_product()
    {
        $seller = User::factory()->create();
        $product = Product::factory()->for($seller)->create();

        $buyer = User::factory()->create();
        Profile::factory()->for($buyer)->create();

        $address =[
            'post_code' => '123-4567',
            'address'=>'東京都',
            'building'=>'テストマンション3階',
        ];
        $this->actingAs($buyer)->followingRedirects() ->patch(route('create.shipping-address', ['item_id' => $product->id]),$address) ->assertSessionHasNoErrors();

        $shippingAddress = ShippingAddress::where('user_id', $buyer->id)
            ->latest('id')
            ->first();
        $this->assertNotNull($shippingAddress);

        $purchaseResponse = $this->post(
            route('purchase.store'),
            [
                'product_id'      => $product->id,
                'payment_method'  => 'card',
                'shipping_address_id' => $shippingAddress->id,
            ]
        );
        $purchaseResponse->assertSessionHasNoErrors();
        $purchaseResponse->assertRedirect(route('home'));

        $this->assertDatabaseHas('purchases', [
            'buyer_user_id' => $buyer->id,
            'product_id' => $product->id,
            'shipping_address_id' => $shippingAddress->id,
            'shipping_post_code' => '123-4567',
            'shipping_address'=>'東京都',
            'shipping_building'=>'テストマンション3階',
            'payment_method' => 'card',
            'status' => 'pending',
        ]);
    }
}
