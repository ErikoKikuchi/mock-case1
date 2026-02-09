<?php

namespace Tests\Feature\Interaction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use App\Models\Product;
use App\Models\Profile;

class LikeTest extends TestCase
{
    use RefreshDatabase;

//いいねアイコンを押下することによって、いいねした商品として登録することができる。
    public function test_user_can_push_like_button()
        {
            $user = User::factory()->create();
            $product=Product::factory()->for($user)->create();

            $likeUser = User::factory()->create();
            Profile::factory()->for($likeUser)->create();

            $this->assertDatabaseCount('likes', 0);

            $response = $this->actingAs($likeUser)->post(
                route('like.product', $product)
            )->assertRedirect();

            $this->assertDatabaseHas('likes', [
                'user_id' => $likeUser->id,
                'product_id' => $product->id,
            ]);

            $productWithCounts = $product->fresh()->loadCount(['likes']);
            $this->assertSame(1, $productWithCounts->likes_count);

            $response = $this->actingAs($likeUser)
                ->get(route('item.detail', ['item_id' => $product->id]));

            $response->assertSee('1');
        }

//追加済みのアイコンは色が変化する
    public function test_like_buttons_color_change_when_it_is_pushed()
        {
            $user = User::factory()->create();
            $product=Product::factory()->for($user)->create();

            $likeUser = User::factory()->create();
            Profile::factory()->for($likeUser)->create();

            Like::factory()->create([
                'user_id' => $likeUser->id,
                'product_id' => $product->id,
            ]);

            $response = $this->actingAs($likeUser)
                ->get(route('item.detail', ['item_id' => $product->id]));

            $response->assertSee('ハートロゴ_ピンク.png');
            $response->assertDontSee('ハートロゴ_デフォルト.png');
        }

//再度いいねアイコンを押下することによって、いいねを解除することができる。
    public function test_user_can_remove_like_by_pushing_like_button_again()
        {
            $user = User::factory()->create();
            $product=Product::factory()->for($user)->create();

            $likeUser = User::factory()->create();
            Profile::factory()->for($likeUser)->create();

            Like::factory()->create([
                'user_id' => $likeUser->id,
                'product_id' => $product->id,
            ]);

            $this->assertDatabaseHas('likes', [
                'user_id' => $likeUser->id,
                'product_id' => $product->id,
            ]);
            $productWithCounts = $product->fresh()->loadCount(['likes']);
            $this->assertSame(1, $productWithCounts->likes_count);

            $this->actingAs($likeUser)->post(
                route('like.product', $product)
            )->assertRedirect();

            $this->assertDatabaseMissing('likes', [
                'user_id' => $likeUser->id,
                'product_id' => $product->id,
            ]);

            $productWithCounts = $product->fresh()->loadCount(['likes']);
            $this->assertSame(0, $productWithCounts->likes_count);

            $response = $this->actingAs($likeUser)
                ->get(route('item.detail', ['item_id' => $product->id]));

            $response->assertDontSee('ハートロゴ_ピンク.png');
            $response->assertSee('ハートロゴ_デフォルト.png');
            $response->assertSee((string) $productWithCounts->likes_count);
        }
}