<?php

namespace Database\Factories;

use App\Models\Student;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    private $availableCompetionPositions = [
        'grade_1',
        'grade_2',
        'grade_3',
    ];

    private $availableCompetionLevels = [
        'school',
        'subdistrict',
        'district',
        'provincial',
        'national',
        'international',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = cloudinary()->adminApi()->assets([
            'resource_type' => 'image',
            'max_results' => 20,
        ])['resources'];

        if (empty($images)) {
            throw new Exception('No cloudinary images found');
        }

        $thumbnailUrl = fake()->randomElement($images)['secure_url'];
        $student = Student::query()->inRandomOrder()->firstOrFail();

        return [
            'student_nis' => $student->nis,
            'student_name' => $student->name,
            'student_class' => $student->class,
            'student_major_id' => $student->major_id,
            'student_major_name' => $student->major_long_name,
            'competition_position' => fake()->randomElement($this->availableCompetionPositions),
            'competition_name' => fake()->company(),
            'competition_level' => fake()->randomElement($this->availableCompetionLevels),
            'won_at' => fake()->date(),
            'thumbnail_url' => $thumbnailUrl,
        ];
    }
}
