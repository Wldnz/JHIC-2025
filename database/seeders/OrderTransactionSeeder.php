<?php

namespace Database\Seeders;

use App\Models\OrderTransaction;
use Illuminate\Database\Seeder;

class OrderTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderTransaction::factory()->count(30)->create();
    }
}
