<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news()
    {
        return view('user.news.index');
    }

    public function newsDetail($article)
    {
        return view('user.news.detail', compact('article'));
    }
}
