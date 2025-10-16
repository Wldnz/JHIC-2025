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
                'started_at' => '2025-01-10',
                'ended_at' => '2025-02-15',
            ],
            [
                'name' => 'Gelombang 2',
                'quota' => 100,
                'started_at' => '2025-02-20',
                'ended_at' => '2025-03-25',
            ],
            [
                'name' => 'Gelombang 3',
                'quota' => 100,
                'started_at' => '2025-04-01',
                'ended_at' => '2025-04-30',
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
