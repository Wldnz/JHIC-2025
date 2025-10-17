<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidateUSMResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CandidateUSMResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $minRequiredValue = 75;
        $signedBy = "Sinta Dewi, S.Pd, M.Kom";

        $candidates = Candidate::query()
            ->with([
                'registrationPhase',
            ])
            ->get();

        foreach ($candidates as $candidate) {
            $selectedMajor = $candidate->candidateMajors()->inRandomOrder()->first();
            $averageValue = random_int(0, 100);

            CandidateUSMResult::create([
                'candidate_nisn' => $candidate->nisn,
                'user_id' => $candidate->user_id,
                'registration_phase_id' => $candidate->registrationPhase->id,
                'selected_major_id' => $selectedMajor->major_id,
                'candidate_full_name' => $candidate->full_name,
                'candidate_origin_school' => $candidate->origin_school,
                'registration_phase_name' => $candidate->registrationPhase->name,
                'selected_major_long_name' => $selectedMajor->major_long_name,
                'min_value' => $minRequiredValue,
                'average_value' => $averageValue,
                'is_passed' => $averageValue >= $minRequiredValue,
                'signed_at' => $candidate->registrationPhase->ended_at,
                'signed_by' => $signedBy,
                'certificate_collection_from_at' => $candidate->registrationPhase->ended_at,
                'certificate_collection_to_at' => Carbon::parse($candidate->registrationPhase->ended_at)->addDays(1),
            ]);
        }
    }
}
