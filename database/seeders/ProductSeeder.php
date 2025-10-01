<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name" => "Almamater",
                "category" => "uniform",
                "description" => "Jas almamater resmi sekolah yang dipakai pada acara formal.",
                "variants" => [
                    [ "name" => "male", "type" => "M", "price" => 150000 ],
                    [ "name" => "male", "type" => "L", "price" => 155000 ],
                    [ "name" => "female", "type" => "M", "price" => 150000 ],
                    [ "name" => "female", "type" => "L", "price" => 155000 ],
                ]
            ],
            [
                "name" => "Seragam Pramuka",
                "category" => "uniform",
                "description" => "Seragam khusus kegiatan Pramuka lengkap dengan atributnya.",
                "variants" => [
                    [ "name" => "male", "type" => "S", "price" => 120000 ],
                    [ "name" => "male", "type" => "M", "price" => 125000 ],
                    [ "name" => "female", "type" => "S", "price" => 120000 ],
                    [ "name" => "female", "type" => "M", "price" => 125000 ],
                ]
            ],
            [
                "name" => "Seragam Batik",
                "category" => "uniform",
                "description" => "Seragam batik yang digunakan pada hari tertentu sesuai aturan sekolah.",
                "variants" => [
                    [ "name" => "male", "type" => "M", "price" => 100000 ],
                    [ "name" => "male", "type" => "XL", "price" => 110000 ],
                    [ "name" => "female", "type" => "M", "price" => 100000 ],
                    [ "name" => "female", "type" => "XL", "price" => 110000 ],
                ]
            ],
            [
                "name" => "Seragam Taqwa",
                "category" => "uniform",
                "description" => "Seragam untuk kegiatan keagamaan dan acara khusus.",
                "variants" => [
                    [ "name" => "male", "type" => "L", "price" => 130000 ],
                    [ "name" => "female", "type" => "L", "price" => 130000 ],
                ]
            ],
            [
                "name" => "Seragam Praktek",
                "category" => "uniform",
                "description" => "Seragam yang dipakai saat kegiatan praktikum di laboratorium atau bengkel.",
                "variants" => [
                    [ "name" => "male", "type" => "M", "price" => 140000 ],
                    [ "name" => "male", "type" => "XL", "price" => 145000 ],
                    [ "name" => "female", "type" => "M", "price" => 140000 ],
                    [ "name" => "female", "type" => "XL", "price" => 145000 ],
                ]
            ],
            [
                "name" => "Seragam Olahraga",
                "category" => "uniform",
                "description" => "Seragam olahraga untuk kegiatan senam, latihan fisik, dan pertandingan.",
                "variants" => [
                    [ "name" => "male", "type" => "M", "price" => 95000 ],
                    [ "name" => "male", "type" => "L", "price" => 100000 ],
                    [ "name" => "female", "type" => "M", "price" => 95000 ],
                    [ "name" => "female", "type" => "L", "price" => 100000 ],
                ]
            ],
            [
                "name" => "Dasi",
                "category" => "attribute",
                "description" => "Atribut wajib seragam formal berupa dasi sekolah.",
                "variants" => [
                    [ "name" => "universal", "type" => "ALL", "price" => 25000 ],
                ]
            ],
            [
                "name" => "Topi",
                "category" => "attribute",
                "description" => "Topi sekolah resmi untuk kelengkapan seragam.",
                "variants" => [
                    [ "name" => "universal", "type" => "ALL", "price" => 30000 ],
                ]
            ],
            [
                "name" => "Sabuk",
                "category" => "attribute",
                "description" => "Sabuk (ikat pinggang) khusus seragam sekolah.",
                "variants" => [
                    [ "name" => "universal", "type" => "ALL", "price" => 35000 ],
                ]
            ],
            [
                "name" => "Badge",
                "category" => "attribute",
                "description" => "Lencana identitas sekolah yang ditempel pada seragam.",
                "variants" => [
                    [ "name" => "universal", "type" => "ALL", "price" => 15000 ],
                ]
            ],
            [
                "name" => "MAP Rapot",
                "category" => "attribute",
                "description" => "Map khusus untuk menyimpan rapor siswa.",
                "variants" => [
                    [ "name" => "universal", "type" => "A4", "price" => 20000 ],
                    [ "name" => "universal", "type" => "Folio", "price" => 22000 ],
                ]
            ],
            [
                "name" => "Sepatu",
                "category" => "attribute",
                "description" => "Sepatu hitam standar sekolah untuk digunakan sehari-hari.",
                "variants" => [
                    [ "name" => "male", "type" => "40", "price" => 175000 ],
                    [ "name" => "male", "type" => "41", "price" => 180000 ],
                    [ "name" => "female", "type" => "38", "price" => 165000 ],
                    [ "name" => "female", "type" => "39", "price" => 170000 ],
                ]
            ]
        ];

        foreach ($data as $productData){
            $product = Product::create([
                "name" => $productData['name'],
                "category" => $productData['category'],
                "description" => $productData['description'],
                "visible" => true,
            ]);

            $isThumbnail = true;
            $remainsImageCount = 3;

            foreach ($productData['variants'] as $variantData) {
                $variant = ProductVariant::create([
                    "product_id" => $product->id,
                    "name" => $variantData['name'],
                    "type" => $variantData['type'],
                    "price" => $variantData['price'],
                    "stock" => fake()->numberBetween(0, 100),
                ]);

                if ($remainsImageCount <= 0) continue;

                $image = ProductImage::create([
                    "product_id" => $product->id,
                    "url" => "https://placehold.co/120x120",
                    "thumbnail" => $isThumbnail,
                    "visible" => true,
                ]);

                $remainsImageCount--;
                $isThumbnail = false;
            }

        }
    }
}
