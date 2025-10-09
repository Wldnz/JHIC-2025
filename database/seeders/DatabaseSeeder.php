<?php

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
    }

    /**
     * Truncate all models.
     */
    private function truncateAllModels(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::query()->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
