<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'title' => $this->faker->word(),
        'image' =>'products/' . $this->faker->uuid . '.jpg',
        'description' => $this->faker->text(255),
        'price' => $this->faker->randomNumber(),
        'condition' => $this->faker->numberBetween(1,4)
        ];
    }
    //カテゴリの作成
    public function configure()
    {
        return $this->afterCreating(function ($product) {
            $categories = Category::factory()->count(2)->create();
            $product->categories()->attach($categories->pluck('id'));
        });
    }

    // Productを作った後に pending purchase を1件作る
    public function sold()
    {
        return $this->afterCreating(function ($product) {
        $buyer = User::factory()->create();
        $profile = Profile::factory()->for($buyer)->create();

        Purchase::factory()->create([
            'buyer_user_id'      => $buyer->id,
            'seller_user_id'     => $product->user_id,
            'product_id'         => $product->id,
            'payment_method'     => 'convenience',
            'status'             => 'pending',

            // 必須カラムを埋める
            'shipping_post_code' => $profile->post_code,
            'shipping_address'   => $profile->address,
            'shipping_building'  => $profile->building,
            'shipping_address_id'=> null,
        ]);
    });
    }
}
