<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Major;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class MajorsController extends Controller
{
    private $visibleAchievementColumns = [
        'id',
        'student_name',
        'competition_position',
        'competition_name',
        'thumbnail_url',
    ];
    private $visiblePortfolioColumns = [
        'id',
        'student_name',
        'title',
        'description',
    ];
    private $visiblePortfolioImageColumns = [
        'id',
        'portfolio_id',
        'url',
    ];
    private $visibleAlumnusColumns = [
        'id',
        'image_url',
        'name',
        'message',
        'current_company',
        'current_company_position',
    ];

    public function animation()
    {
        $major = Major::query()->where('short_name', '=', 'ANM')->first();
        $achievements = $major->achievements()
            ->limit(15)
            ->orderBy('competition_position', 'asc')
            ->get($this->visibleAchievementColumns);
        $portfolios = $major->portfolios()
            ->with([
                'portfolioImages' => function ($query) {
                    $query
                        ->select($this->visiblePortfolioImageColumns)
                        ->where('is_thumbnail', '=', true)
                        ->limit(1);
                }
            ])
            ->limit(15)
            ->get($this->visiblePortfolioColumns);
        $alumni = $major->alumni()
            ->limit(3)
            ->get($this->visibleAlumnusColumns);

        return view('user.majors.animation', compact('achievements', 'portfolios', 'alumni'));
    }

    public function broadcasting()
    {
        $major = Major::query()->where('short_name', '=', 'BC')->first();
        $achievements = $major->achievements()
            ->limit(15)
            ->orderBy('competition_position', 'asc')
            ->get($this->visibleAchievementColumns);
        $portfolios = $major->portfolios()
            ->with([
                'portfolioImages' => function ($query) {
                    $query
                        ->select($this->visiblePortfolioImageColumns)
                        ->where('is_thumbnail', '=', true)
                        ->limit(1);
                }
            ])
            ->limit(15)
            ->get($this->visiblePortfolioColumns);
        $alumni = $major->alumni()
            ->limit(3)
            ->get($this->visibleAlumnusColumns);

        return view('user.majors.broadcasting', compact('achievements', 'portfolios', 'alumni'));
    }

    public function visualCommunicationDesign()
    {
        $major = Major::query()->where('short_name', '=', 'DKV')->first();
        $achievements = $major->achievements()
            ->limit(15)
            ->orderBy('competition_position', 'asc')
            ->get($this->visibleAchievementColumns);
        $portfolios = $major->portfolios()
            ->with([
                'portfolioImages' => function ($query) {
                    $query
                        ->select($this->visiblePortfolioImageColumns)
                        ->where('is_thumbnail', '=', true)
                        ->limit(1);
                }
            ])
            ->limit(15)
            ->get($this->visiblePortfolioColumns);
        $alumni = $major->alumni()
            ->limit(3)
            ->get($this->visibleAlumnusColumns);

        return view('user.majors.visual-communication-design', compact('achievements', 'portfolios', 'alumni'));
    }

    public function softwareEngineering()
    {
        $major = Major::query()->where('short_name', '=', 'RPL')->first();
        $achievements = $major->achievements()
            ->limit(15)
            ->orderBy('competition_position', 'asc')
            ->get($this->visibleAchievementColumns);
        $portfolios = $major->portfolios()
            ->with([
                'portfolioImages' => function ($query) {
                    $query
                        ->select($this->visiblePortfolioImageColumns)
                        ->where('is_thumbnail', '=', true)
                        ->limit(1);
                }
            ])
            ->limit(15)
            ->get($this->visiblePortfolioColumns);
        $alumni = $major->alumni()
            ->limit(3)
            ->get($this->visibleAlumnusColumns);

        return view('user.majors.software-engineering', compact('achievements', 'portfolios', 'alumni'));
    }

    public function networkEngineering()
    {
        $major = Major::query()->where('short_name', '=', 'TKJ')->first();
        $achievements = $major->achievements()
            ->limit(15)
            ->orderBy('competition_position', 'asc')
            ->get($this->visibleAchievementColumns);
        $portfolios = $major->portfolios()
            ->with([
                'portfolioImages' => function ($query) {
                    $query
                        ->select($this->visiblePortfolioImageColumns)
                        ->where('is_thumbnail', '=', true)
                        ->limit(1);
                }
            ])
            ->limit(15)
            ->get($this->visiblePortfolioColumns);
        $alumni = $major->alumni()
            ->limit(3)
            ->get($this->visibleAlumnusColumns);

        return view('user.majors.network-engineering', compact('achievements', 'portfolios', 'alumni'));
    }

    public function gameDevelopment()
    {
        $major = Major::query()->where('short_name', '=', 'GAMEDEV')->first();
        $achievements = $major->achievements()
            ->limit(15)
            ->orderBy('competition_position', 'asc')
            ->get($this->visibleAchievementColumns);
        $portfolios = $major->portfolios()
            ->with([
                'portfolioImages' => function ($query) {
                    $query
                        ->select($this->visiblePortfolioImageColumns)
                        ->where('is_thumbnail', '=', true)
                        ->limit(1);
                }
            ])
            ->limit(15)
            ->get($this->visiblePortfolioColumns);
        $alumni = $major->alumni()
            ->limit(3)
            ->get($this->visibleAlumnusColumns);

        return view('user.majors.game-development', compact('achievements', 'portfolios', 'alumni'));
    }
}
