<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Keyword;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $limit = fake()->numberBetween(1, Article::query()->count());
        $articles = Article::query()->inRandomOrder()->limit($limit)->get();
        $words = [
            'pendidikan',
            'siswa',
            'guru',
            'sekolah',
            'pembelajaran',
            'ekstrakurikuler',
            'prestasi',
            'kurikulum',
            'ujian',
            'kegiatan sekolah'
        ];

        $keywordCount = fake()->numberBetween(3, 10);
        $keywords = [];
        for ($i = 0; $i < $keywordCount; $i++) {
            $keywords[] = Keyword::create([
                'name' => $words[$i],
            ]);
        }

        foreach ($articles as $article) {
            $article->keywords()->attach(
                fake()->randomElements($keywords, 3)
            );
        }
    }
}
