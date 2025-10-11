<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidateMajor;
use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateMajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = Candidate::all();
        $majors = Major::all();

        foreach ($candidates as $candidate) {
            $selectedMajors = $majors->random(rand(1, 2));

            foreach ($selectedMajors as $major) {
                CandidateMajor::query()->insert([
                    'candidate_nisn' => $candidate->nisn,
                    'major_id' => $major->id,
                    'major_long_name' => $major->long_name,
                    'major_short_name' => $major->short_name,
                ]);
            }
        }
    }
}
