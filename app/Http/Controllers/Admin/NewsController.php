<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Article;
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
    protected $gdriveFilesContentDirectory = 'articles';
    protected $availableStatus = [
        "Draft" => 'draft',
        "Published" => 'published',
        "Archived" => 'archived',
    ];

    public function news()
    {
        return view('admin.news.index');
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

            foreach($validated['tags'] as $tag) {
                $keyword = Keyword::createOrFirst([
                    'name' => $tag,
                ], [
                    'name' => $tag
                ]);
                $article->keywords()->attach($keyword->id);
            }

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
        $availableStatus = $this->availableStatus;
        return view('admin.news.detail', compact('news', 'availableStatus'));
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

            foreach ($news->keywords as $keyword) {
                if (!in_array($keyword->name, $validated['tags'])) {
                    $news->keywords()->detach($keyword->id);
                    $keyword->delete();
                }
            }

            foreach ($validated['tags'] as $tag) {
                $keyword = Keyword::createOrFirst([
                    'name' => $tag,
                ], [
                    'name' => $tag
                ]);
                $news->keywords()->syncWithoutDetaching($keyword->id);
            }

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
            redirect()->route('admin.news');

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
