<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Major;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class MajorsController extends Controller
{
    protected $initiliazeAchievements = null;
    protected $initiliazePortfolios = null;

    public function __construct(){
        $this->initiliazeAchievements = Achievement::all();
        $this->initiliazePortfolios = Portfolio::with('portfolioImages');
    }

    public function animation()
    {
        $major = Major::query()->where('short_name', '=', 'ANM')->first();
        $achievements = $this->initiliazeAchievements
        ->where('student_major_name', '=', 'Animasi');
        $portfolios = $this->initiliazePortfolios->where('student_major_name', '=', 'Animasi')
            ->get();
        $alumni = $major->alumni()->limit(3)->get();
        return view('user.majors.animation', compact('achievements', 'portfolios', 'alumni'));
    }

    public function broadcasting()
    {
        $achievements = $this->initiliazeAchievements
        ->where('student_major_name', '=', 'Broadcasting');
        $portfolios = $this->initiliazePortfolios->where('student_major_name', '=', 'Broadcasting')
            ->get();
        return view('user.majors.broadcasting', compact('achievements', 'portfolios'));
    }

    public function visualCommunicationDesign()
    {
        $achievements = $this->initiliazeAchievements
        ->where('student_major_name', '=', 'Desain Komunikasi Visual');
        $portfolios = $this->initiliazePortfolios->where('student_major_name', '=', 'Desain Komunikasi Visual')
            ->get();
        return view('user.majors.visual-communication-design', compact('achievements', 'portfolios'));
    }

    public function softwareEngineering()
    {
        $achievements = $this->initiliazeAchievements
        ->where('student_major_name', '=', 'Rekayasa Perangkat Lunak');
        $portfolios = $this->initiliazePortfolios->where('student_major_name', '=', 'Rekayasa Perangkat Lunak')
            ->get();
        return view('user.majors.software-engineering', compact('achievements', 'portfolios'));
    }

    public function networkEngineering()
    {
        $achievements = $this->initiliazeAchievements
        ->where('student_major_name', '=', 'Teknik Jaringan Komputer');
        $portfolios = $this->initiliazePortfolios->where('student_major_name', '=', 'Teknik Jaringan Komputer')
            ->get();
        return view('user.majors.network-engineering', compact('achievements', 'portfolios'));
    }

    public function gameDevelopment()
    {
        $achievements = $this->initiliazeAchievements
        ->where('student_major_name', '=', 'Game Development');
        $portfolios = $this->initiliazePortfolios->where('student_major_name', '=', 'Game Development')
            ->get();
        return view('user.majors.game-development', compact('achievements', 'portfolios'));
    }
}
