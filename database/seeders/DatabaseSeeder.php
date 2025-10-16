<?php

namespace Database\Seeders;

use App\Models\CandidateDocument;
use App\Models\CandidatePhase;
use App\Models\Keyword;
use App\Models\MajorAlumnus;
use App\Models\RegistrationDocument;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\Student;
use App\Models\GalleryType;
use App\Models\Portfolio;
use App\Models\RegistrationPhase;
use App\Models\RegistrationSource;
use App\Models\Candidate;
use App\Models\Gallery;
use App\Models\PortfolioImage;
use App\Models\Achievement;
use App\Models\CandidateMajor;
use App\Models\CandidateGuardian;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->resetAllModels();
        $this->call(UserSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(MajorAlumnusSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(GalleryTypeSeeder::class);
        $this->call(PortfolioSeeder::class);
        $this->call(RegistrationPhaseSeeder::class);
        $this->call(RegistrationSourceSeeder::class);
        $this->call(RegistrationDocumentSeeder::class);
        $this->call(CandidateSeeder::class);
        $this->call(GallerySeeder::class);
        $this->call(PortfolioImageSeeder::class);
        $this->call(AchievementSeeder::class);
        $this->call(CandidateMajorSeeder::class);
        $this->call(CandidateGuardianSeeder::class);
        $this->call(CandidatePhaseSeeder::class);
        $this->call(CandidateDocumentSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(KeywordSeeder::class);
    }

    /**
     * Truncate all models.
     */
    private function resetAllModels(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::query()->truncate();
        Major::query()->truncate();
        MajorAlumnus::query()->truncate();

        Student::query()->delete();
        DB::statement("ALTER TABLE " . (new Student())->getTable() . " AUTO_INCREMENT = 1");

        GalleryType::query()->truncate();
        Portfolio::query()->delete();
        DB::statement("ALTER TABLE " . (new Portfolio())->getTable() . " AUTO_INCREMENT = 1");

        RegistrationPhase::query()->truncate();
        RegistrationSource::query()->truncate();
        RegistrationDocument::query()->truncate();

        Candidate::query()->delete();
        DB::statement("ALTER TABLE " . (new Candidate())->getTable() . " AUTO_INCREMENT = 1");

        Gallery::query()->truncate();
        PortfolioImage::query()->truncate();

        Achievement::query()->delete();
        DB::statement("ALTER TABLE " . (new Achievement())->getTable() . " AUTO_INCREMENT = 1");

        CandidateMajor::query()->truncate();
        CandidateGuardian::query()->truncate();
        CandidatePhase::query()->truncate();
        CandidateDocument::query()->truncate();
        PaymentMethod::query()->truncate();

        Transaction::query()->delete();
        DB::statement("ALTER TABLE " . (new Transaction())->getTable() . " AUTO_INCREMENT = 1");

        Article::query()->truncate();
        Keyword::query()->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
