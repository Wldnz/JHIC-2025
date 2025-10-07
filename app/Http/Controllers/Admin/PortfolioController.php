<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function portfolio()
    {
        return view('admin.portfolio.index');
    }

    public function createPortfolio()
    {
        return view('admin.portfolio.create');
    }

    public function storePortfolio(Request $request)
    {
        return back();
    }

    public function detailPortfolio($portfolio)
    {
        return view('admin.portfolio.detail', compact('portfolio'));
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
