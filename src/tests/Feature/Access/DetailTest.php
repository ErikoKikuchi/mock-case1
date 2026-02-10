<?php

namespace Tests\Feature\Access;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Comment;
use App\Models\Category;

class DetailTest extends TestCase
{
    use RefreshDatabase;

//必要な情報が表示される（商品画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、商品情報（カテゴリ、商品の状態）、コメント数、コメントしたユーザー情報、コメント内容）
    public function test_user_can_see_details_of_the_product()
    {
        $user = User::factory()->create();
        $product=Product::factory()->for($user)->create();
        $category = Category::factory()->create();
        $product->categories()->attach($category->id);
        $formattedPrice = number_format($product->price);

        $commentUser = User::factory()->create();
        Profile::factory()->for($commentUser)->create();

        $comment = Comment::factory()->for($product)->for($commentUser)->create();

        Like::factory()->for($product)->for($commentUser)->create();

        $product = $product->fresh()->loadCount(['likes','comments']);
        $response = $this->get(route('item.detail', ['item_id' => $product->id]));

        $response->assertOk();
        $response->assertSee('/storage/products/', false);
        $response->assertSee($product->title);
        $response->assertSee($product->brand);
        $response->assertSee($formattedPrice);
        $response->assertSee((string) $product->likes_count);
        $response->assertSeeInOrder([
            (string) $product->comments_count,
            (string) $product->comments_count,
        ]);
        $response->assertSee($product->description);
        $response->assertSee($category->name);
        $response->assertSee($product->condition_label);
        $response->assertSee($commentUser->profile->name);
        $response->assertSee($comment->body);
    }
//複数選択されたカテゴリが表示されているか
    public function test_user_can_see_several_categories()
    {
        $user = User::factory()->create();
        $product=Product::factory()->for($user)->create();
        $categoryA = Category::factory()->create(['name'=>'ファッション']);
        $categoryB = Category::factory()->create(['name'=>'レディース']);
        $product->categories()->attach([$categoryA->id,$categoryB->id]);
        $response = $this->get(route('item.detail', ['item_id' => $product->id]));
        $response->assertOk();
        $response->assertSee('ファッション');
        $response->assertSee('レディース');
    }
}