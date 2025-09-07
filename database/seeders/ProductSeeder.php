<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()
        ->count(10)
        ->create();

        ProductVariant::factory()
        ->count(20)
        ->create();

        ProductImage::factory()
        ->count(4)
        ->create();
    }
}
