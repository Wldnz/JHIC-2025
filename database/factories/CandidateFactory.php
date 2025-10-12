<?php

namespace Database\Factories;

use App\Models\RegistrationPhase;
use App\Models\RegistrationSource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    private $availableGenders = [
        'male',
        'female'
    ];
    private $availableCitizenships = [
        'indonesia',
        'other',
    ];
    private $availableReligions = [
        'islam',
        'catholic',
        'buddha',
        'hindu',
        'protestant',
        'confucian',
        'other'
    ];
    private $availableStatusesFamily = [
        'biological_child',
        'adopted_child',
        'step_child',
        'foster_child'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first();

        return [
            'nisn' => fake()->numerify('##########'),
            'user_id' => $user->id,
            'full_name' => fake()->name(),
            'short_name' => fake()->firstName(),
            'birthdate' => fake()->date(),
            'birthplace' => fake()->city(),
            'gender' => fake()->randomElement($this->availableGenders),
            'citizenship' => fake()->randomElement($this->availableCitizenships),
            'religion' => fake()->randomElement($this->availableReligions),
            'address' => fake()->address(),
            'status_family' => fake()->randomElement($this->availableStatusesFamily),
            'order_family' => fake()->randomNumber(),
            'sum_siblings' => fake()->randomNumber(),
            'sum_half_siblings' => fake()->randomNumber(),
            'sum_adopted_siblings' => fake()->randomNumber(),
            'phone' => fake()->phoneNumber(),
            'created_at' => fake()->dateTime(),
            'origin_school' => fake()->company(),
            'origin_school_address' => fake()->address(),
        ];
    }
}
