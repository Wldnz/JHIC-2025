<?php

namespace Database\Factories;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()
            ->where('role', '=', 'article_creator')
            ->inRandomOrder()
            ->firstOrFail();

        $publicDirPath = 'images\news';
        $imageTag = 'bi article';
        $maxResults = 5;

        $images = cloudinary()->adminApi()->assetsByTag(
            $imageTag,
            [
                'resource_type' => 'image',
                'max_results' => $maxResults,
                'fields' => 'secure_url',
            ],
        )['resources'];

        if (count($images) < $maxResults) {
            $imageFiles = File::files(public_path($publicDirPath));

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

        if (empty($images)) {
            throw new Exception('No cloudinary images found');
        }

        $thumbnailUrl = fake()->randomElement($images)['secure_url'];

        $currentTimestamp = time();
        Gdrive::put(
            "articles/$currentTimestamp.txt",
            Storage::disk('local')->path('articles/placeholder.txt')
        );
        $fileContentUrl = Storage::disk('google')->url("articles/$currentTimestamp.txt");

        echo "Aricle content file has been saved in Google Drive: ( $fileContentUrl )\n";

        return [
            'title' => fake()->sentence(4),
            'file_content_url' => $fileContentUrl,
            'thumbnail_url' => $thumbnailUrl,
            'writter_user_id' => $user->id,
            'written_by' => $user->fullname,
            'status' => 'published',
        ];
    }
}
