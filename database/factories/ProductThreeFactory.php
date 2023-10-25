<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductThree>
 */
class ProductThreeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_number' => $this->faker->randomNumber(9, true),
            'traders_password' => $this->faker->word(),
            'server' => 'Exness-trial-10',
            'leverage' => '1:1000',
            'status' => 'inactive',
            'mode' => $this->faker->randomElement(['demo', 'real']),
            // 'purchased_at' => $this->faker->randomElement([$this->faker->dateTimeBetween('-1 years', 'now'), null]),
        ];
    }
}
