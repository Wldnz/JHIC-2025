<?php

namespace Database\Seeders;

use App\Models\Major;
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
        $users = User::query()->where('role', '=', 'siswa')->get();

        $users->each(function ($user) {
            $major = Major::query()->inRandomOrder()->firstOrFail();
            Student::create([
                'nis' => $user->nis,
                'no_telp' => fake()->phoneNumber(),
                'gender' => fake()->randomElement(['male', 'female']),
                'address' => fake()->address(),
                'birthdate' => fake()->date(),
                'class' => fake()->randomElement(['X', 'XI', 'XII']),
                'major_id' => $major->id,
                'major_name' => $major->name,
            ]);
        });
    }
}
