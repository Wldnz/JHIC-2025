<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\PortfolioImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PortfolioImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publicDirPath = 'images/portfolios';
        $imageTag = 'portfolio';

        $portfolios = Portfolio::all();

        foreach ($portfolios as $portfolio) {
            $maxResults = 10;

            $images = cloudinary()->adminApi()->assetsByTag(
                $portfolio->major->short_name,
                [
                    'resource_type' => 'image',
                    'max_results' => $maxResults,
                    'fields' => 'secure_url,tags',
                ],
            )['resources'];

            if (count($images) < $maxResults) {
                $imageFiles = File::files(public_path($publicDirPath));
                $imageFiles = array_filter($imageFiles, function ($image) use ($portfolio) {
                    return str_starts_with($image->getFilename(), $portfolio->major->short_name);
                });

                for ($i = 0; $i < ($maxResults - count($images)); $i++) {
                    $uploadedUrl = cloudinary()->uploadApi()->upload(
                        fake()->randomElement($imageFiles)->getPathname(),
                        [
                            'resource_type' => 'image',
                            'tags' => "$imageTag,{$portfolio->major->short_name}",
                        ]
                    )['secure_url'];

                    $images[] = [
                        'secure_url' => $uploadedUrl,
                        'tags' => [$imageTag, $portfolio->major->short_name],
                    ];
                }
            }

            for ($i = 0; $i < 3; $i++) {
                $thumbnailUrl = fake()->randomElement($images)['secure_url'];
                $isThumbnail = $portfolio->portfolioImages()->where('is_thumbnail', true)->exists() == false;

                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'url' => $thumbnailUrl,
                    'is_thumbnail' => $isThumbnail,
                ]);
            }

        }
    }
}
