<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()
            ->where('role', '=', 'candidate')
            ->offset(200)
            ->limit(100)
            ->get(['id', 'fullname']);

        foreach ($users as $user) {
            Candidate::factory()->create([
                'user_id' => $user->id,
                'full_name' => $user->fullname,
            ]);
        }
    }
}
