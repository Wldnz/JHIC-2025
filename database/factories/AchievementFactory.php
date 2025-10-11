<?php

namespace Database\Factories;

use App\Models\Student;
use App\Utilities\CloudinaryUtils;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

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
        $imageTag = 'student person';
        $maxResults = 20;

        $images = cloudinary()->adminApi()->assetsByTag(
            $imageTag,
            [
                'resource_type' => 'image',
                'max_results' => $maxResults,
                'fields' => 'secure_url',
            ],
        )['resources'];

        if (count($images) < $maxResults) {
            $imageFiles = File::files(public_path('images\student persons'));

            for ($i = 0; $i < ($maxResults - count($images)); $i++) {
                $uploadedUrl = cloudinary()->uploadApi()->upload(
                    fake()->randomElement($imageFiles)->getPathname(),
                    [
                        'resource_type' => 'image',
                        'tags' => $imageTag,
                    ]
                )['secure_url'];

                $images[] = [
                    'secure_url' => $uploadedUrl,
                ];
            }
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
