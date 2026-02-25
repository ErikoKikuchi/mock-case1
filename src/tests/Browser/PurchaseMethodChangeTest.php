<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PurchaseMethodChangeTest extends DuskTestCase
{
    public function test_purchase_method_change_is_reflected_on_summary()
    {
        $seller = User::factory()->create();
        $seller->markEmailAsVerified();
        $product = Product::factory()->for($seller)->create();

        $buyer = User::factory()->create();
        $buyer->markEmailAsVerified();
        Profile::factory()->for($buyer)->create();

        $this->browse(function (Browser $browser) use ($buyer, $product) {
            $browser->loginAs($buyer)
                ->visit(route('purchase.show', ['item_id' => $product->id]))
                ->pause(3000)
                ->screenshot('debug') 
                ->assertSee('支払方法')

                // プルダウンで「カード支払い」を選択
                ->select('#payment_method_select', 'card')
                ->pause(200)

                ->assertSee('カード支払い');
        });
    }
}
