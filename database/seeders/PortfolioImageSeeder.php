<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\PortfolioImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portfolios = Portfolio::all();

        foreach ($portfolios as $portfolio) {
            PortfolioImage::factory()->count(3)->create([
                'portfolio_id' => $portfolio->id,
            ]);
        }
    }
}
