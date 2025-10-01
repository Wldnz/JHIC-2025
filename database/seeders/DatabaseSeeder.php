<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Cart;
use App\Models\Major;
use App\Models\OrderTransaction;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateAllModels();
        $this->call(MajorSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(OrderTransactionSeeder::class);
    }

    /**
     * Truncate all models.
     */
    private function truncateAllModels(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Activity::query()->truncate();
        Cart::query()->truncate();
        OrderTransaction::query()->truncate();
        Transaction::query()->truncate();
        PaymentType::query()->truncate();
        ProductVariant::query()->truncate();
        ProductImage::query()->truncate();
        Product::query()->truncate();
        User::query()->truncate();
        Major::query()->truncate();
        Student::query()->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
