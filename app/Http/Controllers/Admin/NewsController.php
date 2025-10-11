<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news()
    {
        return view('admin.news.index');
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        dd($request);
        return back();
    }

    public function detailNews($news)
    {
        return view('admin.news.detail', compact('news'));
    }

    public function updateNews(Request $request, $news)
    {
        return back();
    }

    public function deleteNews($news)
    {
        return back();
    }
}
