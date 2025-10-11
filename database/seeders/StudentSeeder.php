<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()
            ->where('role', '=', 'candidate')
            ->offset(0)
            ->limit(200)
            ->get(['id', 'fullname']);

        foreach ($users as $user) {
            Student::factory()->create([
                'user_id' => $user->id,
                'name' => $user->fullname,
            ]);
        }
    }
}
