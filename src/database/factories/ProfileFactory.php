<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->name(),
            'image'=>'profiles/' . $this->faker->uuid . '.jpg',
            'post_code'=>$this->faker->numerify('#######'),
            'address'=>$this->faker->city(),
            'building'=>$this->faker->secondaryAddress(),
            'user_id'=>User::factory(),
        ];
    }
}
