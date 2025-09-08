<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'product_id' => Product::inRandomOrder()->first()->id,
            'name' => fake()->name(),
            'type' => $this->typesOrSizes[array_rand($this->typesOrSizes)],
            'price' => str_pad(rand(0,9), rand(0,6),'2', STR_PAD_LEFT),
            'stock' => random_int(1,100)    
        ];
    }
}
