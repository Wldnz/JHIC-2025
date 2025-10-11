<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    private $availableStatuses = [
        'authorize',
        'capture',
        'settlement',
        'deny',
        'pending',
        'cancel',
        'refund',
        'partial_refund',
        'partial_chargeback',
        'expire',
        'failure',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $candidate = Candidate::query()->inRandomOrder()->first();
        $paymentMethod = PaymentMethod::query()->inRandomOrder()->first();
        
        return [
            'candidate_nisn' => $candidate->nisn,
            'candidate_full_name' => $candidate->full_name,
            'payment_method_id' => $paymentMethod->id,
            'payment_method_display_name' => $paymentMethod->display_name,
            'total_cost' => 5_787_900,
            'expired_at' => now()->addHours(rand(12, 24)),
            'status' => fake()->randomElement($this->availableStatuses),
        ];
    }
}
