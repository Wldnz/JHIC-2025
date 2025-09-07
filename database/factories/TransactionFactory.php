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

    protected $status = ['pending','success','ongoing','fail'];
    public function definition(): array
    {
        return [
            'user_nis' => User::inRandomOrder()->first()->nis,
            'received_email' => fake()->email(),
            'received_phone' => 812469653,
            'total_product' => rand(1,5),
            'total_price' => rand(20000, 400000),
            'expired' => now()->addDays(1),
            'status' => $this->status[array_rand($this->status)]
        ];
    }
}
