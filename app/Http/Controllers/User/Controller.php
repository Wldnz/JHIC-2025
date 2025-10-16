<?php

namespace App\Http\Controllers\User;

use App\Models\Article;
use App\Models\Gallery;
use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $articles = Article::with('keywords')
        ->limit('3')
        ->orderByDesc('created_at')
        ->get();

        $galleries = Gallery::limit(6)->get();

        return view('user.index', compact('articles', 'galleries'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function uniforms()
    {
        return view('user.uniforms');
    }

    public function visiMisi()
    {
        return view('user.visi-misi');
    }

    public function galleries()
    {
        $galleries = Gallery::all();
        return view('user.galleries', compact('galleries'));
    }

    public function facilities()
    {
        $facilities = Gallery::all();
        return view('user.facilities', compact('facilities'));
    }
}
