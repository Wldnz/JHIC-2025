<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $status = ['pending', 'success', 'ongoing', 'fail'];
    public function definition(): array
    {
        return [
            'user_nis' => User::query()->inRandomOrder()->first()->nis,
            'received_email' => fake()->email(),
            'received_phone' => fake()->phoneNumber(),
            'total_product' => fake()->numberBetween(1, 10),
            'total_price' => fake()->numberBetween(100_000, 1_000_000),
            'payment_method' => fake()->creditCardType(),
            'expired_at' => now()->addDays(3),
            'received_at' => fake()->dateTimeBetween(now(), now()->addDays(3)),
            'status' => fake()->randomElement($this->status),
            'note' => fake()->optional()->text(100),
        ];
    }
}
