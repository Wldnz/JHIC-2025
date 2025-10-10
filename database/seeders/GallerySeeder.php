<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryType;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = cloudinary()->adminApi()->assets([
            'resource_type' => 'image',
            'max_results' => 30,
        ])['resources'];

        if (empty($images)) {
            throw new Exception('No cloudinary images found');
        }

        $galleryTypes = GalleryType::all();

        foreach ($galleryTypes as $galleryType) {
            $imageUrl = fake()->randomElement($images)['secure_url'];
            $galleryData = [];

            for ($i = 0; $i < 5; $i++) {
                $galleryData[] = [
                    'name' => fake()->name(),
                    'url' => $imageUrl,
                    'description' => fake()->text(),
                    'media_type' => 'image',
                    'gallery_type_id' => $galleryType->id,
                    'gallery_type_name' => $galleryType->name,
                ];
            }

            Gallery::query()->insert($galleryData);
        }
    }
}
