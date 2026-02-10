<?php

namespace Tests\Feature\Information;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

//商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格）
    public function test_user_can_exhibit_product()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Profile::factory()->for($user)->create();

        $category = Category::factory()->create();
        $product=[
            'title'=>'テスト商品',
            'image'=> UploadedFile::fake()->create('test.jpeg', 100, 'image/jpeg'),
            'brand'=>'テストブランド',
            'description'=>'商品の説明です',
            'price'=>1000,
            'condition'=>1,
            'categories' => [$category->id],
        ];

        $response = $this->actingAs($user)->post(route('exhibition.store'),$product);
        $response->assertSessionHasNoErrors();

        $createdProduct = Product::where('title', 'テスト商品')->latest('id')->first();
        $this->assertNotNull($createdProduct);

        $this->assertDatabaseHas('products', [
            'id'          => $createdProduct->id,
            'title'       => 'テスト商品',
            'brand'       => 'テストブランド',
            'description' => '商品の説明です',
            'price'       => 1000,
            'user_id'     => $user->id,
            'condition'   => 1,
        ]);

        $this->assertDatabaseHas('category_product', [
            'product_id'  => $createdProduct->id,
            'category_id' => $category->id,
        ]);
    }
}