<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePortfolioRequest;
use App\Http\Requests\Admin\UpdatePortfolioRequest;
use App\Models\Major;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Models\Student;
use App\Utilities\AlertDataGenerator;
use App\Utilities\CloudinaryUtils;
use App\Utilities\FileUploadUtils;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PortfolioController extends Controller
{

    protected $maxPage = 4;

    public function portfolio(Request $request)
    {
        $search = $request->get('search', '');
        $search_major = $request->get('search_major', '');
        $search_class = $request->get('search_class', '');
        $page =  $request->get('page', 1);
        $majors = Major::all();
        $max = $this->maxPage;

        $portfolioStats = Portfolio::query()
            ->selectRaw("COUNT(*) AS total")
            ->selectRaw("COUNT(CASE WHEN student_class = 'X' THEN 1 END) AS xth")
            ->selectRaw("COUNT(CASE WHEN student_class = 'XI' THEN 1 END) AS xith")
            ->selectRaw("COUNT(CASE WHEN student_class = 'XII' THEN 1 END) AS xiith")
            ->first();
        $portfolios = Portfolio::query();

        $stats = [
            'total' => $portfolioStats->total,
            '10th' => $portfolioStats->xth,
            '11th' => $portfolioStats->xith,
            '12th' => $portfolioStats->xiith,
        ];

        if ($search) {
            $portfolios = $portfolios
                ->orWhere('title', 'like', "%$search%")
                ->orWhere('student_name', 'like', "%$search%")
                ->orWhere('student_class', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        if ($search_major) {
            $portfolios = $portfolios->where('student_major_name', '=', $search_major);
        }

        if ($search_class) {
            $portfolios = $portfolios->where('student_class', '=', $search_class);
        }

        $total = $portfolios->count();
        $portfolios = $portfolios->limit($this->maxPage)
            ->offset(($page - 1) * $this->maxPage)
            ->get(['id', 'title', 'description', 'student_name', 'student_class', 'student_major_name']);

        $portfolios->load([
            'portfolioImages' => function ($query) {
                $query
                    ->where('is_thumbnail', '=', true)
                    ->limit(1)
                    ->select(['id', 'portfolio_id', 'url']);
            }
        ]);

        return view('admin.portfolio.index', compact('portfolios', 'page', 'max', 'total', 'stats', 'majors'));
    }

    public function createPortfolio()
    {
        $students = Student::all(['nis', 'name', 'class', 'major_id', 'major_long_name']);
        $availableLinkTypes = [
            "Youtube" => 'youtube',
            "Instagram" => 'instagram',
            "Tiktok" => 'tiktok',
            "Website" => 'website',
            "Lainnya" => 'other',
        ];

        return view('admin.portfolio.create', compact('students', 'availableLinkTypes'));
    }

    public function storePortfolio(StorePortfolioRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $student = Student::find(
                $validated['student_nis'],
                ['name', 'class', 'major_id', 'major_long_name']
            );
            if (!$student) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal menambahkan portfolio",
                    "Siswa dengan NIS {$validated['student_nis']} tidak ditemukan",
                    $request->session(),
                );
                throw new Exception("Siswa dengan NIS {$validated['student_nis']} tidak ditemukan");
            }

            $portfolio = Portfolio::create([
                'student_nis' => $validated['student_nis'],
                'student_name' => $student->name,
                'student_class' => $student->class,
                'student_major_id' => $student->major_id,
                'student_major_name' => $student->major_long_name,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'link_type' => $validated['type'],
                'supporting_link' => $validated['link'],
            ]);

            if (!$portfolio) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal menambahkan portfolio",
                    "Terjadi kesalahan saat menambahkan portfolio",
                    $request->session(),
                );
                throw new Exception("Terjadi kesalahan saat menambahkan portfolio");
            }

            $addedImageFilesData = FileUploadUtils::splitFileUploads($request, 'images')->addedFilesData;
            $portfolioImagesData = [];
            $haveThumbnail = false;
            $dateNow = now();

            if (count($addedImageFilesData) > 0) {
                foreach ($addedImageFilesData as $addedImageData) {
                    $uploadedUrl = CloudinaryUtils::uploadImageFile($addedImageData['file']);

                    $portfolioImagesData[] = [
                        'portfolio_id' => $portfolio->id,
                        'url' => $uploadedUrl,
                        'is_thumbnail' => $haveThumbnail ? false : $addedImageData['thumbnail'],
                        'created_at' => $dateNow,
                        'updated_at' => $dateNow,
                    ];

                    if ($addedImageData['thumbnail']) {
                        $haveThumbnail = true;
                    }
                }
            }

            if (count($portfolioImagesData) > 0) {
                PortfolioImage::query()->insert($portfolioImagesData);
            } else {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal menambahkan portfolio",
                    "Minimal pilih 1 gambar",
                    $request->session(),
                );
                throw new Exception("Minimal pilih 1 gambar");
            }

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menambahkan portfolio",
                "Berhasil menambahkan portfolio untuk siswa \"{$portfolio->student_name}\"",
                $request->session(),
            );

            return redirect()->route('admin.portfolio');
        } catch (Throwable $th) {
            DB::rollBack();

            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan portfolio",
                $th->getMessage(),
                $request->session(),
            );

            return back()->withInput($request->all());
        }
    }

    public function detailPortfolio(Portfolio $portfolio)
    {
        $students = Student::all(['nis', 'name', 'class', 'major_id', 'major_long_name']);
        $portfolio->load('portfolioImages');

        $availableLinkTypes = [
            "Youtube" => 'youtube',
            "Instagram" => 'instagram',
            "Tiktok" => 'tiktok',
            "Website" => 'website',
            "Lainnya" => 'other',
        ];

        return view('admin.portfolio.detail', compact('portfolio', 'students', 'availableLinkTypes'));
    }

    public function updatePortfolio(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $student = Student::find(
                $validated['student_nis'],
                ['name', 'class', 'major_id', 'major_long_name']
            );
            if (!$student) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal mengupdate portfolio",
                    "Siswa dengan NIS {$validated['student_nis']} tidak ditemukan",
                    $request->session(),
                );
                throw new Exception("Siswa dengan NIS {$validated['student_nis']} tidak ditemukan");
            }

            $isUpdated = $portfolio->update([
                'student_nis' => $validated['student_nis'],
                'student_name' => $student->name,
                'student_class' => $student->class,
                'student_major_id' => $student->major_id,
                'student_major_name' => $student->major_long_name,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'link_type' => $validated['type'],
                'supporting_link' => $validated['link'],
            ]);

            if (!$isUpdated) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal mengupdate portfolio",
                    "Terjadi kesalahan saat mengupdate portfolio",
                    $request->session(),
                );
                throw new Exception("Terjadi kesalahan saat mengupdate portfolio");
            }

            $portfolio->load('portfolioImages');

            $splittedDataFiles = FileUploadUtils::splitFileUploads($request, 'images');
            $deletedPortfolioImageIds = [];
            $haveThumbnail = false;
            $dateNow = now();

            logger(json_encode($splittedDataFiles->notAddedFilesData));

            foreach ($portfolio->portfolioImages as $portfolioImage) {
                logger($portfolioImage->id);
                logger(array_key_exists($portfolioImage->id, $splittedDataFiles->notAddedFilesData));
                if (!array_key_exists($portfolioImage->id, $splittedDataFiles->notAddedFilesData)) {
                    $deletedPortfolioImageIds[] = $portfolioImage->id;
                    continue;
                }
                $notAddedFileData = $splittedDataFiles->notAddedFilesData[$portfolioImage->id];

                if ($notAddedFileData['thumbnail'] && !$haveThumbnail) {
                    $portfolioImage->is_thumbnail = true;
                    $haveThumbnail = true;
                } else {
                    $portfolioImage->is_thumbnail = false;
                }

                if (!($notAddedFileData['file'] ?? false)) {
                    $isUpdated = $portfolioImage->save();

                    if (!$isUpdated) {
                        AlertDataGenerator::generateAsFlashToSession(
                            AlertType::DANGER,
                            "Gagal mengupdate portfolio",
                            "Terjadi kesalahan saat mengupdate data gambar portfolio",
                            $request->session(),
                        );
                        throw new Exception("Terjadi kesalahan saat mengupdate data gambar portfolio");
                    }

                    continue;
                }

                $publicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($portfolioImage->url);
                if (!$publicId) {
                    AlertDataGenerator::generateAsFlashToSession(
                        AlertType::DANGER,
                        "Gagal mengupdate portfolio",
                        "Terjadi kesalahan saat mengganti gambar portfolio (public id tidak ditemukan)",
                        $request->session(),
                    );
                    throw new Exception("Terjadi kesalahan saat mengganti gambar portfolio");
                }

                $uploadedUrl = CloudinaryUtils::replaceImageFile($notAddedFileData['file'], $publicId);
                if (!$uploadedUrl) {
                    AlertDataGenerator::generateAsFlashToSession(
                        AlertType::DANGER,
                        "Gagal mengupdate portfolio",
                        "Terjadi kesalahan saat mengganti gambar portfolio (gagal mengupload gambar)",
                        $request->session(),
                    );
                    throw new Exception("Terjadi kesalahan saat mengganti gambar portfolio");
                }

                $portfolioImage->url = $uploadedUrl;
                $isUpdated = $portfolioImage->save();

                if (!$isUpdated) {
                    AlertDataGenerator::generateAsFlashToSession(
                        AlertType::DANGER,
                        "Gagal mengupdate portfolio",
                        "Terjadi kesalahan saat mengupdate data gambar portfolio",
                        $request->session(),
                    );
                    throw new Exception("Terjadi kesalahan saat mengupdate data gambar portfolio");
                }
            }

            if (count($deletedPortfolioImageIds) > 0) {
                PortfolioImage::query()
                    ->whereIn('id', $deletedPortfolioImageIds)
                    ->delete();
            }

            $addedPortfolioImagesData = [];

            if (count($splittedDataFiles->addedFilesData) > 0) {
                foreach ($splittedDataFiles->addedFilesData as $addedFileData) {
                    $uploadedUrl = CloudinaryUtils::uploadImageFile($addedFileData['file']);
                    if (!$uploadedUrl) {
                        AlertDataGenerator::generateAsFlashToSession(
                            AlertType::DANGER,
                            "Gagal mengupdate portfolio",
                            "Terjadi kesalahan saat mengupload gambar portfolio yang baru",
                            $request->session(),
                        );
                        throw new Exception("Terjadi kesalahan saat mengupload gambar portfolio yang baru");
                    }

                    $addedPortfolioImagesData[] = [
                        'portfolio_id' => $portfolio->id,
                        'url' => $uploadedUrl,
                        'is_thumbnail' => $addedFileData['thumbnail'] && !$haveThumbnail,
                        'created_at' => $dateNow,
                        'updated_at' => $dateNow,
                    ];
                }
            }

            if (count($addedPortfolioImagesData) > 0) {
                $isAllInserted = PortfolioImage::query()
                    ->insert($addedPortfolioImagesData);

                if (!$isAllInserted) {
                    AlertDataGenerator::generateAsFlashToSession(
                        AlertType::DANGER,
                        "Gagal mengupdate portfolio",
                        "Terjadi kesalahan saat menambahkan data gambar portfolio",
                        $request->session(),
                    );
                    throw new Exception("Terjadi kesalahan saat menambahkan data gambar portfolio");
                }
            }

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengupdate portfolio",
                "Berhasil mengupdate portfolio untuk siswa \"{$portfolio->student_name}\"",
                $request->session(),
            );

            return redirect()->route('admin.portfolio');
        } catch (Throwable $th) {
            DB::rollBack();

            logger()->error($th);
            report($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate portfolio",
                $th->getMessage(),
                $request->session(),
            );

            return back()->withInput($request->all());
        }
    }

    public function deletePortfolio(Request $request, Portfolio $portfolio)
    {
        foreach ($portfolio->portfolioImages as $portfolioImage) {
            $publicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($portfolioImage->url);
            if (!$publicId) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal menghapus portfolio",
                    "Terjadi kesalahan saat menghapus gambar portfolio (public id tidak ditemukan)",
                    $request->session(),
                );
                return back();
            }

            $isDeleted = CloudinaryUtils::deleteImageFile($publicId);
            if (!$isDeleted) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal menghapus portfolio",
                    "Terjadi kesalahan saat menghapus gambar portfolio",
                    $request->session(),
                );
            }
        }

        $isPortfolioDeleted = $portfolio->delete();
        if ($isPortfolioDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus portfolio",
                "Berhasil menghapus portfolio dengan judul \"{$portfolio->title}\"",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus portfolio",
                "Terjadi kesalahan saat menghapus portfolio",
                $request->session(),
            );
        }

        return back();
    }
}
