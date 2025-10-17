<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Keyword;
use App\Utilities\AlertDataGenerator;
use App\Utilities\CloudinaryUtils;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class NewsController extends Controller
{
    protected $maxPage = 5;
    protected $gdriveFilesContentDirectory = 'articles';
    protected $availableStatus = [
        "Draft" => 'draft',
        "Published" => 'published',
        "Archived" => 'archived',
    ];

    public function news(Request $request)
    {

        $search = $request->get('search', '');
        $search_status = $request->get('search_status', '');
        $page =  $request->get('page', 1);
        $max = $this->maxPage;

        $articles = Article::with('keywords');
        $articleStats = Article::query()
            ->selectRaw("COUNT(*) AS total")
            ->selectRaw("COUNT(CASE WHEN status = 'published' THEN 1 END) AS publish")
            ->selectRaw("COUNT(CASE WHEN status = 'archived' THEN 1 END) AS archive")
            ->selectRaw("COUNT(CASE WHEN status = 'draft' THEN 1 END) AS draft")
            ->first();

        $stats = [
            'total' => $articleStats->total,
            'publish' => $articleStats->publish,
            'archive' => $articleStats->archive,
            'draft' => $articleStats->draft,
        ];

        if($search){
            $articles = $articles->where('title', '=', $search)
                ->orWhere('title', 'like', "%$search%");
        }

        if($search_status){
            $articles = $articles->where('status', '=', $search_status);
        }

        $total = $search || $search_status ? $articles->count() : $stats['total'];
        $articles = $articles->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.news.index', compact('articles', 'stats', 'page', 'max', 'total'));
    }

    public function createNews()
    {
        $availableStatus = $this->availableStatus;
        return view('admin.news.create', compact('availableStatus'));
    }

    public function storeNews(StoreArticleRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();

        try {

            $thumbnailUrl = CloudinaryUtils::uploadImageFile($validated['thumbnail']);
            if (!$thumbnailUrl) {
                throw new Exception("Gagal mengupload gambar thumbnail artikel");
            }

            $currentTimestamp = time();
            $fileContentUrl = Storage::disk('google')->put(
                "$this->gdriveFilesContentDirectory/$currentTimestamp.txt",
                $validated['content'],
            );
            $fileContentUrl = Storage::disk('google')->path("$this->gdriveFilesContentDirectory/$currentTimestamp.txt");
            $description = substr($validated['content'], 0, 255);

            $article = Article::create([
                'title' => $validated['title'],
                'description' => $description,
                'file_content_url' => $fileContentUrl,
                'thumbnail_url' => $thumbnailUrl,
                'writter_user_id' => Auth::user()->id,
                'written_by' => Auth::user()->fullname,
                'status' => $validated['visible'],
            ]);

            if (!$article) {
                throw new Exception("Gagal menambahkan artikel dengan judul \"{$validated['title']}\"");
            }

            $keywordIds = [];
            foreach($validated['tags'] as $tag) {
                $keyword = Keyword::createOrFirst([
                    'name' => $tag,
                ], [
                    'name' => $tag
                ]);
                $keywordIds[] = $keyword->id;
            }
            $article->keywords()->attach($keywordIds);

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menambahkan artikel",
                "Artikel berhasil ditambahkan dengan judul \"{$validated['title']}\"",
                $request->session()
            );
            return redirect()->route('admin.news');

        } catch (Throwable $th) {
            DB::rollBack();

            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan artikel",
                $th->getMessage(),
                $request->session(),
            );

            return back()->withInput($validated);

        }
    }

    public function detailNews(Article $news)
    {
        $article = $news->load('keywords');
        $availableStatus = $this->availableStatus;

        return view('admin.news.detail', compact('article', 'availableStatus'));
    }

    public function updateNews(UpdateArticleRequest $request, Article $news)
    {
        $validated = $request->validated();
        DB::beginTransaction();

        try {
            $thumbnailUrl = $news->thumbnail_url;

            if ($validated['isUpdated']) {
                $thumbnailPublicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($news->thumbnail_url);
                if (!$thumbnailPublicId) {
                    throw new Exception("Gagal menghapus gambar thumbnail artikel (public id tidak ditemukan)");
                }

                $thumbnailUrl = CloudinaryUtils::uploadImageFile($validated['thumbnail']);
                if (!$thumbnailUrl) {
                    throw new Exception("Gagal mengganti gambar thumbnail artikel di cloud");
                }
            }

            $fileContentUrl = $news->file_content_url;
            Storage::disk('google')->put(
                $fileContentUrl,
                $validated['content'],
            );
            $description = substr($validated['content'], 0, 255);

            $deletedKeywordIds = [];
            foreach ($news->keywords as $keyword) {
                if (!in_array($keyword->name, $validated['tags'])) {
                    $news->keywords()->detach($keyword->id);
                    if ($keyword->articles()->count() <= 0) {
                        $deletedKeywordIds[] = $keyword->id;
                    }
                }
            }
            Keyword::destroy($deletedKeywordIds);

            $keywordIds = [];
            foreach ($validated['tags'] as $tag) {
                $keyword = Keyword::createOrFirst([
                    'name' => $tag,
                ], [
                    'name' => $tag
                ]);
                $keywordIds[] = $keyword->id;
            }
            $news->keywords()->syncWithoutDetaching($keywordIds);

            $isUpdated = $news->update([
                'title' => $validated['title'],
                'description' => $description,
                'file_content_url' => $fileContentUrl,
                'thumbnail_url' => $thumbnailUrl,
                'status' => $validated['visible'],
            ]);

            if (!$isUpdated) {
                throw new Exception("Gagal mengupdate artikel dengan judul \"{$validated['title']}\"");
            }

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengupdate artikel",
                "Artikel berhasil diupdate dengan judul \"{$validated['title']}\"",
                $request->session()
            );
            return redirect()->route('admin.news');

        } catch (Throwable $th) {
            DB::rollBack();

            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate artikel",
                $th->getMessage(),
                $request->session(),
            );

            return back()->withInput($validated);

        }
    }

    public function deleteNews(Request $request, Article $news)
    {
        $thumbnailPublicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($news->thumbnail_url);
        if (!$thumbnailPublicId) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate artikel",
                "Gagal menghapus gambar thumbnail artikel (public id tidak ditemukan)",
                $request->session()
            );
            return back();
        }

        $isThumbnailDeleted = CloudinaryUtils::deleteImageFile($thumbnailPublicId);
        if (!$isThumbnailDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate artikel",
                "Gagal menghapus gambar thumbnail artikel",
                $request->session()
            );
            return back();
        }

        Storage::disk('google')->delete($news->file_content_url);
        $isDeleted = $news->delete();

        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus artikel",
                "Berhasil menghapus artikel dengan judul \"{$news->title}\"",
                $request->session()
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus artikel",
                "Gagal menghapus artikel dengan judul \"{$news->title}\"",
                $request->session()
            );
        }

        return back();
    }
}
