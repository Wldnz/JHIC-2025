<?php

namespace Database\Seeders;

use App\Models\Major;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Major::query()->insert([
            [
                'long_name' => 'Animasi',
                'short_name' => 'ANM',
            ],
            [
                'long_name' => 'Desain Komunikasi Visual',
                'short_name' => 'DKV',
            ],
            [
                'long_name' => 'Teknik Komputer Jaringan',
                'short_name' => 'TKJ',
            ],
            [
                'long_name' => 'Rekayasa Perangkat Lunak',
                'short_name' => 'RPL',
            ],
            [
                'long_name' => 'Broadcasting',
                'short_name' => 'BC',
            ],
            [
                'long_name' => 'Game Development',
                'short_name' => 'GAMEDEV',
            ],
        ]);
    }
}
