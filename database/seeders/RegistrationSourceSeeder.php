<?php

namespace Database\Seeders;

use App\Models\RegistrationSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 'name' => 'Spanduk Rentang' ],
            [ 'name' => 'Spanduk Sekolah' ],
            [ 'name' => 'Google' ],
            [ 'name' => 'Google Maps' ],
            [ 'name' => 'Website Sekolah' ],
            [ 'name' => 'Instagram' ],
            [ 'name' => 'Facebook' ],
            [ 'name' => 'Twitter' ],
            [ 'name' => 'Teman' ],
            [ 'name' => 'Keluarga' ],
            [ 'name' => 'Persentasi di SMP' ],
            [ 'name' => 'Kegiatan SMK BI' ],
        ];

        foreach ($data as $item) {
            RegistrationSource::create($item);
        }
    }
}
