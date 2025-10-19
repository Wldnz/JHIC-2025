<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class NewsController extends Controller
{
    public function news(Request $request)
    {
        $searchQuery = $request->query('search');
        $articles = Article::with([
                'keywords' => function ($query) {
                    $query->select(['keywords.id', 'keywords.name']);
                }
            ])
            ->where('status', '=', 'published')
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query
                    ->where('title', 'like', "%$searchQuery%")
                    ->orWhere('description', 'like', "%$searchQuery%")
                    ->orWhere('written_by', 'like', "%$searchQuery%");
            })
            ->orderByDesc('updated_at')
            ->limit(50)
            ->get(['id', 'title', 'description', 'thumbnail_url', 'updated_at']);

        return view('user.news.index', compact('articles'));
    }

    public function newsDetail(Request $request, Article $article)
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
