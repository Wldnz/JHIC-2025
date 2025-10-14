<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $maxPage = 4;
    public function news(Request $request)
    {

        $search = $request->get('search', '');
        $search_status = $request->get('search_status', '');
        $page =  $request->get('page', 1);
        $max = $this->maxPage;

        $articles = Article::select();
        $initiliazeArticles = Article::all();

        $stats = [
            'total' => $initiliazeArticles->count(),
            'publish' => $initiliazeArticles->where('status', '=', 'published')->count(),
            'archive' => $initiliazeArticles->where('status', '=', 'archived')->count(),
            'draft' => $initiliazeArticles->where('status', '=', 'draft')->count(),
        ];

        if($search){
            $articles = $articles->where('title', '=', $search)
                ->orWhere('title', 'like', "%$search%");
        }

        if($search_status){
            $articles = $articles->where('role', '=', $search_status);
        }

        $total = $articles->get()->count();
        $articles = $articles->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.news.index', compact('articles', 'stats', 'page', 'max', 'total'));
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

    public function detailNews(Article $news)
    {
        $article = $news->load('keywords');
        return view('admin.news.detail', compact('article'));
    }

    public function updateNews(Request $request, $news)
    {
        dd($request);
        return back();
    }

    public function deleteNews($news)
    {
        return back();
    }
}
