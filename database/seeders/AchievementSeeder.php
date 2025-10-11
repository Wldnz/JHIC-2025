<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = Major::all();

        foreach ($majors as $major) {
            for ($i = 0; $i < 10; $i++) {
                $student = $major->students()->inRandomOrder()->first();

                Achievement::factory()->create([
                    'student_nis' => $student->nis,
                    'student_name' => $student->name,
                    'student_class' => $student->class,
                    'student_major_id' => $student->major_id,
                    'student_major_name' => $student->major_long_name,
                ]);
            }
        }
    }
}
