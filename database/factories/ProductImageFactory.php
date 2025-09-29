<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();
        return [
            'product_id' => $product->id,
            'url' => 'https://placehold.co/120x120',
            'thumbnail' => $product->images()->count() == 0,
            'visible' => true
        ];
    }
}
