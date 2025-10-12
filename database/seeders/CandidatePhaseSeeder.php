<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidatePhase;
use App\Models\RegistrationPhase;
use App\Models\RegistrationSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidatePhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = Candidate::all();

        foreach ($candidates as $candidate) {
            $registrationPhase = RegistrationPhase::query()->inRandomOrder()->first();
            $registrationSource = RegistrationSource::query()->inRandomOrder()->first();

            CandidatePhase::create([
                'candidate_nisn' => $candidate->nisn,
                'selected_phase_id' => $registrationPhase->id,
                'selected_phase_name' => $registrationPhase->name,
                'registration_source_id' => $registrationSource->id,
                'registration_source' => $registrationSource->name,
                'enrolling_reason' => fake()->sentence(5),
                'created_at' => fake()->dateTime(),
            ]);
        }
    }
}
