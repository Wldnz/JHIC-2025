<?php

namespace Database\Seeders;

use App\Models\GalleryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GalleryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GalleryType::query()->insert([
            [ 'name' => 'Classroom' ],
            [ 'name' => 'Laboratorium' ],
            [ 'name' => 'Public Facility' ],
        ]);
    }
}
