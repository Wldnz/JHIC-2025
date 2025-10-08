<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function achievement()
    {
        return view('admin.achievement.index');
    }

    public function createAchievement()
    {
        $students = Student::all()->load('user');
        return view('admin.achievement.create', compact('students'));
    }

    public function storeAchievement(Request $request)
    {
        return back();
    }

    public function detailAchievement($achievement)
    {
        $students = Student::all()->load('user');
        return view('admin.achievement.detail', compact('achievement', 'students'));
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
