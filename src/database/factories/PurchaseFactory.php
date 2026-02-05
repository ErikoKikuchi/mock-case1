<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'buyer_user_id'=> User::factory(),
            'payment_method'=> 'convenience',
            'status'=> 'pending',
        ];
    }
    public function forProduct(Product $product): static
    {
        return $this->state(fn() => [
            'product_id' => $product->id,
            'seller_user_id' => $product->user_id,
        ]);
    }
    public function pending(): static
    {
        return $this->state(fn() => ['status' => 'pending']);
    }
}
