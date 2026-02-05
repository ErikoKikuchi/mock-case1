<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Product;
use Database\Factories\PurchaseFactory;

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
    public function sold(): static
    {
        return $this->afterCreating(function ($product) {
            Purchase::factory()
                ->pending()
                ->forProduct($product)
                ->create();
        });
    }
}
