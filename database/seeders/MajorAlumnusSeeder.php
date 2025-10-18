<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\MajorAlumnus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MajorAlumnusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = Major::all();

        $publicDirPath = 'images\student persons';
        $imageTag = 'alumni';
        $maxResults = $majors->count() * (3 + 5);

        $alumnusImages = cloudinary()->adminApi()->assetsByTag(
            $imageTag,
            [
                'resource_type' => 'image',
                'max_results' => $maxResults,
                'fields' => 'secure_url',
            ],
        )['resources'];

        if (count($alumnusImages) < $maxResults) {
            $imageFiles = File::files(public_path($publicDirPath));

            for ($i = 0; $i < ($maxResults - count($alumnusImages)); $i++) {
                $uploadedUrl = cloudinary()->uploadApi()->upload(
                    fake()->randomElement($imageFiles)->getPathname(),
                    [
                        'resource_type' => 'image',
                        'tags' => $imageTag,
                    ]
                )['secure_url'];

                $alumnusImages[] = [
                    'secure_url' => $uploadedUrl,
                ];
            }
        }

        foreach ($majors as $major) {
            for ($i = 0; $i < random_int(0,3); $i++) {
                $alumnusImageIndex = random_int(0, count($alumnusImages) - 1);
                $alumnusImage = $alumnusImages[$alumnusImageIndex];
                $isHaveCompany = random_int(0, 1);

                unset($alumnusImages[$alumnusImageIndex]);
                $alumnusImages = array_values($alumnusImages);

                MajorAlumnus::create([
                    'major_id' => $major->id,
                    'image_url' => $alumnusImage['secure_url'],
                    'name' => fake()->name(),
                    'message' => fake()->sentence(),
                    'major_long_name' => $major->long_name,
                    'major_short_name' => $major->short_name,
                    'current_company' => $isHaveCompany ? fake()->company() : null,
                    'current_company_position' => $isHaveCompany ? fake()->jobTitle() : null,
                ]);
            }
        }
    }
}
