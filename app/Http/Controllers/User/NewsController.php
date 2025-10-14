<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

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

    public function newsContent(Article $article)
    {
        $readStream = Gdrive::readStream($article->file_content_url);
        return response()->stream(function() use($readStream) {
            fpassthru($readStream->file);
        }, 200, [
            'Content-Type' => $readStream->ext,
        ]);
    }
}
