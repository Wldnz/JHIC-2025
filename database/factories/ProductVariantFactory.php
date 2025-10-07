<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $typesOrSizes = [
        'XL',
        'L',
        'S',
        'Jumbo',
        'XXL'
    ];
    public function definition(): array
    {
        return [
            'product_id' => Product::query()->inRandomOrder()->first()->id,
            'name' => fake()->sentence(2, true),
            'type' => fake()->randomElement($this->typesOrSizes),
            'price' => fake()->numberBetween(1_000, 100_000),
            'stock' => fake()->numberBetween(1, 100),
        ];
    }
}
