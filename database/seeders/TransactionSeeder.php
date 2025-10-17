<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
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
    private $availableStatusesWithoutSuccess = [
        'authorize',
        'capture',
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
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = Candidate::all();
        $paymentMethod = PaymentMethod::query()->inRandomOrder()->first();
        $haveSuccessTransaction = false;

        foreach ($candidates as $candidate) {
            for ($i=0; $i < random_int(0, 3); $i++) {
                $transaction = Transaction::create([
                    'candidate_nisn' => $candidate->nisn,
                    'user_id' => $candidate->user_id,
                    'candidate_full_name' => $candidate->full_name,
                    'user_email' => $candidate->user->email,
                    'payment_method_id' => $paymentMethod->id,
                    'payment_method_display_name' => $paymentMethod->display_name,
                    'total_cost' => 5_787_900,
                    'expired_at' => now()->addHours(rand(12, 24)),
                    'status' => $haveSuccessTransaction ?
                        fake()->randomElement($this->availableStatusesWithoutSuccess) :
                        fake()->randomElement($this->availableStatuses),
                    'type' => fake()->randomElement(['form', 'usm']),
                ]);

                if (!$haveSuccessTransaction && $transaction->status == 'settlement') {
                    $haveSuccessTransaction = true;
                }
            }

            $haveSuccessTransaction = false;
        }
    }
}
