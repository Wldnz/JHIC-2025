<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function portfolio()
    {
        return view('admin.portfolio.index');
    }

    public function createPortfolio()
    {
        $students = Student::all()->load('user');
        return view('admin.portfolio.create', compact('students'));
    }

    public function storePortfolio(Request $request)
    {
        return back();
    }

    public function detailPortfolio($portfolio)
    {
        $students = Student::all()->load('user');
        return view('admin.portfolio.detail', compact('portfolio', 'students'));
    }

    public function updatePortfolio(Request $request, $portfolio)
    {
        return back();
    }

    public function deletePortfolio($portfolio)
    {
        return back();
    }
}
