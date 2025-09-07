<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\OrderTransaction;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cart::factory()->count(10)->create();
        Transaction::factory()->count(8)->create();
        OrderTransaction::factory()->count(20)->create();
    }
}
