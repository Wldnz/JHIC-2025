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
            ->where('status', '=', 'published')
            ->limit(3)
            ->orderByDesc('updated_at')
            ->get(['id', 'title', 'description', 'file_content_url', 'thumbnail_url']);

        $galleries = Gallery::query()
            ->inRandomOrder()
            ->limit(6)
            ->get(['id', 'name', 'url']);

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
        $galleries = Gallery::query()
            ->limit(200)
            ->get(['id', 'name', 'url', 'description', 'gallery_type_name']);
        return view('user.galleries', compact('galleries'));
    }

    public function facilities()
    {
        $facilities = Gallery::query()
            ->limit(200)
            ->get(['id', 'name', 'url', 'description', 'gallery_type_name']);
        return view('user.facilities', compact('facilities'));
    }
}
