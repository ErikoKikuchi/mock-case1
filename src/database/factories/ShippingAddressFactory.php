<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\ShippingAddress;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingAddress>
 */
class ShippingAddressFactory extends Factory
{
    protected $model = ShippingAddress::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_code'=>$this->faker->numerify('#######'),
            'address'=>$this->faker->city(),
            'building'=>$this->faker->secondaryAddress(),
            'user_id'=>User::factory(),
        ];
    }
}
