<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    private $availableGenders = [
        'male',
        'female',
    ];
    private $availableClasses = [
        'X',
        'XI',
        'XII',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $major = Major::query()->inRandomOrder()->first();
        $user = User::query()->inRandomOrder()->first();

        return [
            'nis' => fake()->numerify('#################'),
            'user_id' => $user->id,
            'name' => fake()->name(),
            'class' => fake()->randomElement($this->availableClasses),
            'major_id' => $major->id,
            'major_long_name' => $major->long_name,
            'major_short_name' => $major->short_name,
            'gender' => fake()->randomElement($this->availableGenders),
            'birthdate' => fake()->date(),
            'created_at' => fake()->dateTime(),
        ];
    }
}
