<?php

namespace Database\Seeders;

use App\Models\RegistrationPhase;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phases = [
            [
                'name' => 'Gelombang 1',
                'quota' => 100,
            ],
            [
                'name' => 'Gelombang 2',
                'quota' => 100,
            ],
            [
                'name' => 'Gelombang 3',
                'quota' => 100,
            ],
        ];

        foreach ($phases as $phase) {
            $startedAt = fake()->date();
            $endedAt = fake()->date(max: Carbon::parse($startedAt)->addDays(30));

            RegistrationPhase::create([
                'name' => $phase['name'],
                'quota' => $phase['quota'],
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
            ]);
        }
    }
}
