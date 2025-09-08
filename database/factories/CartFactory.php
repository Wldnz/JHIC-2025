<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'user_nis' => User::inRandomOrder()->first()->nis,
            'product_variant_id' => ProductVariant::inRandomOrder()->first()->id,
            'quantity' => rand(1,3),
        ];
    }
}
