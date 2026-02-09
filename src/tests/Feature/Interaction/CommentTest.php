<?php

namespace Tests\Feature\Interaction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;

class CommentTest extends TestCase
{
    use RefreshDatabase;

//ログイン済みのユーザーはコメントを送信できる
    public function test_login_user_can_send_comment()
    {
        $user = User::factory()->create();
        $product=Product::factory()->for($user)->create();

        $commentUser = User::factory()->create();
        Profile::factory()->for($commentUser)->create();

        $this->assertDatabaseCount('comments', 0);

        $payload = ['body' => 'テストコメント'];

        $response = $this->actingAs($commentUser)->post(
            route('comment', $product),$payload
        )->assertRedirect();
        $response->assertSessionHasNoErrors(); 

        $this->assertDatabaseHas('comments', [
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'body' => 'テストコメント'
        ]);

        $productWithCounts = $product->fresh()->loadCount(['comments']);
            $this->assertSame(1, $productWithCounts->comments_count);

        $response = $this->actingAs($commentUser)
                ->get(route('item.detail', ['item_id' => $product->id]));

        $response->assertSee((string) $productWithCounts->comments_count);;
    }

//ログイン前のユーザーはコメントを送信できない
    public function test_before_login_user_cannot_send_comment()
        {
            $user = User::factory()->create();
            $product=Product::factory()->for($user)->create();

            $this->assertDatabaseCount('comments', 0);

            $payload = ['body' => 'テストコメント'];
            $response = $this->post(
                route('comment', $product),$payload);

            $response->assertRedirect(route('login'));

            $this->assertDatabaseCount('comments', 0);
        }

//コメントが入力されていない場合、バリデーションメッセージが表示される
    public function test_sending_comment_requires_body()
        {
            $user = User::factory()->create();
            $product=Product::factory()->for($user)->create();

            $commentUser = User::factory()->create();
            Profile::factory()->for($commentUser)->create();

            $this->assertDatabaseCount('comments', 0);

            $response = $this->actingAs($commentUser)->post(
                route('comment', $product), ['body' => '']
            )->assertRedirect();
            $response->assertSessionHasErrors([
                'body'=>'コメントを入力してください'
            ]);
            $this->assertDatabaseCount('comments', 0);
        }

//コメントが255字以上の場合、バリデーションメッセージが表示される
    public function test_comment_body_over_255_shows_validation_message()
        {
            $user = User::factory()->create();
            $product=Product::factory()->for($user)->create();

            $commentUser = User::factory()->create();
            Profile::factory()->for($commentUser)->create();

            $tooLong = str_repeat('あ', 256);
            $response = $this->actingAs($commentUser)->post(
                route('comment', $product), ['body' => $tooLong]
            )->assertRedirect();
            $response->assertSessionHasErrors([
                'body'=>'コメントは２５５文字以内で入力してください'
            ]);
        }

}
