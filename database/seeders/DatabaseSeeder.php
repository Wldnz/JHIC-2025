<?php

namespace Database\Seeders;

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

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateAllModels();
        // $this->call(UserSeeder::class);
        // $this->call(MajorSeeder::class);
        // $this->call(StudentSeeder::class);
        // $this->call(GalleryTypeSeeder::class);
        // $this->call(PortfolioSeeder::class);
        // $this->call(RegistrationPhaseSeeder::class);
        // $this->call(RegistrationSourceSeeder::class);
        // $this->call(CandidateSeeder::class);
        // $this->call(GallerySeeder::class);
        $this->call(PortfolioImageSeeder::class);
        // $this->call(AchievementSeeder::class);
        // $this->call(CandidateMajorSeeder::class);
        // $this->call(CandidateGuardianSeeder::class);
        // $this->call(PaymentMethodSeeder::class);
        // $this->call(TransactionSeeder::class);
    }

    /**
     * Truncate all models.
     */
    private function truncateAllModels(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // User::query()->truncate();
        // Major::query()->truncate();
        // Student::query()->truncate();
        // GalleryType::query()->truncate();
        // Portfolio::query()->truncate();
        // RegistrationPhase::query()->truncate();
        // RegistrationSource::query()->truncate();
        // Candidate::query()->truncate();
        // Gallery::query()->truncate();
        PortfolioImage::query()->truncate();
        // Achievement::query()->truncate();
        // CandidateMajor::query()->truncate();
        // CandidateGuardian::query()->truncate();
        // PaymentMethod::query()->truncate();
        // Transaction::query()->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
