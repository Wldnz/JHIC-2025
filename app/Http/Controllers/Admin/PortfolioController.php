<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{

    protected $maxPage = 4;

    public function portfolio(Request $request)
    {
        $search = $request->get('search', '');
        $search_major = $request->get('search_major', '');
        $page =  $request->get('page', 1);
        $max = $this->maxPage;

        $initiliazePortfolios = Portfolio::all();
        $portfolios = Portfolio::with('portfolioImages');
        $stats = [
            'total' => $initiliazePortfolios->count(),
            '10th' => $initiliazePortfolios->where('student_class', '=', 'X')->count(),
            '11th' => $initiliazePortfolios->where('student_class', '=', 'XI')->count(),
            '12th' => $initiliazePortfolios->where('student_class', '=', 'XII')->count(),
        ];
        if ($search) {
            $portfolios = $portfolios->where('title', '=', $search)
                ->orWhere('title', 'like', '%' . $search . '%');
        }
        if ($search_major) {
            $portfolios = $portfolios->where('student_major_name', '=', $search_major);
        }
        $total = $portfolios->count();
        $portfolios = $portfolios->limit($this->maxPage)
            ->offset(($page - 1) * $this->maxPage)
            ->get();
        return view('admin.portfolio.index', compact('portfolios', 'page', 'max', 'total', 'stats'));
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

    public function detailPortfolio(Portfolio $portfolio)
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
