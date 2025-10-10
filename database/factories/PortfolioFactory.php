<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    private $availableLinkTypes = [
        'youtube',
        'instagram',
        'tiktok',
        'website',
        'other'
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = Student::query()->inRandomOrder()->firstOrFail();

        return [
            'student_nis' => $student->nis,
            'student_name' => $student->name,
            'student_class' => $student->class,
            'student_major_id' => $student->major_id,
            'student_major_name' => $student->major_long_name,
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'link_type' => fake()->randomElement($this->availableLinkTypes),
            'supporting_link' => fake()->url(),
        ];
    }
}
