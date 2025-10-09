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
        $productVariant = ProductVariant::query()->inRandomOrder()->first();
        $quantity = fake()->numberBetween(1, 100);

        return [
            'transaction_id' => Transaction::query()->inRandomOrder()->first()->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => $quantity,
            'price' => $productVariant->price * $quantity,
        ];
    }
}
