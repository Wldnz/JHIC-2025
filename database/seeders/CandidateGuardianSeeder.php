<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidateGuardian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateGuardianSeeder extends Seeder
{
    private $availableGenders = [
        'male',
        'female'
    ];
    private $availableCitizenships = [
        'indonesia',
        'other',
    ];
    private $availableReligions = [
        'islam',
        'catholic',
        'buddha',
        'hindu',
        'protestant',
        'confucian',
        'other'
    ];
    private $availableEducations = [
        'SD/MI',
        'SMP/MTs',
        'SMA/SMK',
        'Diploma',
        'Sarjana',
        'Magister',
        'Spesialis',
        'Doktor',
    ];
    private $availableGuardianTypes = [
        'mother',
        'father',
        'other',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = Candidate::all();

        foreach ($candidates as $candidate) {
            CandidateGuardian::create([
                'candidate_nisn' => $candidate->nisn,
                'user_id' => $candidate->user_id,
                'guardian_type' => fake()->randomElement($this->availableGuardianTypes),
                'full_name' => fake()->name(),
                'birthplace' => fake()->city(),
                'birthdate' => fake()->date(),
                'citizenship' => fake()->randomElement($this->availableCitizenships),
                'religion' => fake()->randomElement($this->availableReligions),
                'education' => fake()->randomElement($this->availableEducations),
                'job' => fake()->jobTitle(),
                'monthly_income' => fake()->numberBetween(1_000_000, 10_000_000),
                'home_address' => fake()->address(),
                'rt_rw' => fake()->regexify('[0-9]{2}/[0-9]{2}'),
                'sub_district' => fake()->city(),
                'district' => fake()->city(),
                'city' => fake()->city(),
                'postal_code' => fake()->postcode(),
                'home_phone_number' => fake()->phoneNumber(),
                'office_phone_number' => fake()->phoneNumber(),
                'phone_number' => fake()->phoneNumber(),
            ]);
        }
    }
}
