<?php

namespace Database\Seeders;

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
        DB::table('majors')->insert([
            ['name' => 'Animasi'],
            ['name' => 'Desain Komunikasi Visual'],
            ['name' => 'Teknik Komputer Jaringan'],
            ['name' => 'Rekayasa Perangkat Lunak'],
            ['name' => 'Broadcasting'],
            ['name' => 'Game Development'],
        ]);
    }
}
