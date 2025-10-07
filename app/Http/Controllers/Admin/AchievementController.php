<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function achievement()
    {
        return view('admin.achievement.index');
    }

    public function createAchievement()
    {
        return view('admin.achievement.create');
    }

    public function storeAchievement(Request $request)
    {
        return back();
    }

    public function detailAchievement($achievement)
    {
        return view('admin.achievement.detail', compact('achievement'));
    }

    public function updateAchievement(Request $request, $achievement)
    {
        return back();
    }

    public function deleteAchievement($achievement)
    {
        return back();
    }
}
