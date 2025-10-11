<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortfolioImage>
 */
class PortfolioImageFactory extends Factory
{
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
        $portfolio = Portfolio::query()->inRandomOrder()->firstOrFail();
        $isThumbnail = $portfolio->portfolioImages()->where('is_thumbnail', true)->exists() == false;

        return [
            'portfolio_id' => $portfolio->id,
            'url' => $thumbnailUrl,
            'is_thumbnail' => $isThumbnail,
        ];
    }
}
