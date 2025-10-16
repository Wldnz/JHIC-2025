<?php

namespace Database\Seeders;

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
                'fullname' => 'Admin',
                'email' => 'admin@example.com',
                'phone' => '086598987678',
                'email_verified_at' => now(),
                'password' => bcrypt('admin1234#'),
                'remember_token' => Str::random(10),
                'role' => 'admin',
            ],
            [
                'fullname' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'phone' => '086598987679',
                'email_verified_at' => now(),
                'password' => bcrypt('superadmin1234#'),
                'remember_token' => Str::random(10),
                'role' => 'super_admin',
            ],
            [
                'fullname' => 'Radit Si Pembuat Article',
                'email' => 'radit@article.com',
                'phone' => '086598987639',
                'email_verified_at' => now(),
                'password' => bcrypt('raditarticle123#'),
                'remember_token' => Str::random(10),
                'role' => 'article_creator',
            ],
            [
                'fullname' => 'Ahtvi Si Calon Didik',
                'email' => 'ahtvi@cpd.id',
                'phone' => '086598982639',
                'email_verified_at' => now(),
                'password' => bcrypt('athvicpd123#'),
                'remember_token' => Str::random(10),
                'role' => 'candidate',
            ]
        ]);

        User::factory()->count(200 + 100)->create([
            'role' => 'candidate',
        ]);
        User::factory()->count(10)->create([
            'role' => 'article_creator',
        ]);
        User::factory()->count(10)->create([
            'role' => 'admin',
        ]);
    }
}
