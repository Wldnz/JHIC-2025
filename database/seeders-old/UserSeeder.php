<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->insert([
            [
                'nis' => '1234567890123456',
                'fullname' => 'Admin',
                'email' => 'admin@example.com',
                'phone' => '086598987678',
                'email_verified_at' => now(),
                'password' => bcrypt('admin1234#'),
                'remember_token' => Str::random(10),
                'role' => 'admin',
            ],
            [
                'nis' => '0987654321098765',
                'fullname' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'phone' => '086598987679',
                'email_verified_at' => now(),
                'password' => bcrypt('superadmin1234#'),
                'remember_token' => Str::random(10),
                'role' => 'superAdmin',
            ]
        ]);

        User::factory()->count(10)->create();
    }
}
