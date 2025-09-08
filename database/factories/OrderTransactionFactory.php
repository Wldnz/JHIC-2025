<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderTransaction>
 */
class OrderTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::inRandomOrder()->first()->id,
            'product_variant_id' => ProductVariant::inRandomOrder()->first()->id,
            'quantity' => rand(1,3),
            'price' => rand(1,3) * 35000,
        ];
    }
}
