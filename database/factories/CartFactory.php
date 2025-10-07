<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_nis' => User::query()->inRandomOrder()->first()->nis,
            'product_variant_id' => ProductVariant::query()->inRandomOrder()->first()->id,
            'quantity' => fake()->numberBetween(1, 100),
        ];
    }
}
