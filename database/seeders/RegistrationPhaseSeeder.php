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
                'started_at' => '2025-08-23',
                'ended_at' => '2025-11-06',
            ],
            [
                'name' => 'Gelombang 2',
                'quota' => 100,
                'started_at' => '2026-02-13',
                'ended_at' => '2026-02-14',
            ],
            [
                'name' => 'Gelombang 3',
                'quota' => 100,
                'started_at' => '2026-06-23',
                'ended_at' => '2026-06-24',
            ],
        ];

        foreach ($phases as $phase) {
            $startedAt = Carbon::parse($phase['started_at'])->years(Carbon::now()->year);
            $endedAt = Carbon::parse($phase['ended_at'])->years(Carbon::now()->year);

            RegistrationPhase::create([
                'name' => $phase['name'],
                'quota' => $phase['quota'],
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
            ]);
        }
    }
}
