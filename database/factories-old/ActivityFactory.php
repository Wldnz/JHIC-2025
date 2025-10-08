<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first();
        return [
            'user_nis' => $user->nis,
            'fullname' => $user->fullname,
            'action' => fake()->sentence(),
        ];
    }
}
