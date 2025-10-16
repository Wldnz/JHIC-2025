<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAchievementRequest;
use App\Http\Requests\Admin\UpdateAchievementRequest;
use App\Models\Achievement;
use App\Models\Major;
use App\Models\Student;
use App\Utilities\AlertDataGenerator;
use App\Utilities\CloudinaryUtils;
use App\Utilities\FileUploadUtils;
use Illuminate\Http\Request;

class AchievementController extends Controller
{

    protected $maxPage = 3;
    public function achievement(Request $request)
    {
        $search = $request->query('search', null);
        $search_major = $request->query('search_major', null);
        $search_class = $request->query('search_class', null);
        $page = $request->query('page', 1);
        $max = $this->maxPage;
        $achievements = Achievement::query();

        $stats = [
            'total' => $achievements->count(),
        ];

        $majors = Major::all();

        $achievements = Achievement::query()
            ->orderBy('id', 'asc')
            ->when($search, function ($query, $search) {
                return $query
                    ->where('competition_name', 'like', "%{$search}%")
                    ->orWhere('student_name', 'like', "%{$search}%")
                    ->orWhere('student_class', 'like', "%{$search}%")
                    ->orWhere('student_major_name', 'like', "%{$search}%");
            })
            ->when($search_major, function ($query, $search_major) {
                return $query->where('student_major_name', "=", $search_major);
            })
            ->when($search_class, function ($query, $search_class) {
                return $query->where('student_class', "=", $search_class);
            });

        $totalPage =  $search || $search_major || $search_class ? $achievements->count() : $stats['total'];
        $achievements= $achievements
            ->limit($this->maxPage)
            ->offset(($page - 1) * $this->maxPage)
            ->get(['id', 'student_name', 'competition_position', 'competition_name', 'thumbnail_url']);

        return view('admin.achievement.index', compact('achievements', 'stats', 'page', 'totalPage', 'max', 'majors'));
    }

    public function createAchievement()
    {
        $students = Student::all(['nis', 'name', 'class', 'major_id','major_long_name']);
        $competitionPositions = [
            "Juara 1" => 'grade_1',
            "Juara 2" => 'grade_2',
            "Juara 3" => 'grade_3',
        ];
        $competitionLevels = [
            "Sekolah" => 'school',
            "Kecamatan" => 'subdistrict',
            "Kota" => 'district',
            "Provinsi" => 'provincial',
            "Nasional" => 'national',
            "International" => 'international',
        ];

        return view('admin.achievement.create', compact('students', 'competitionPositions', 'competitionLevels'));
    }

    public function storeAchievement(StoreAchievementRequest $request)
    {
        $validated = $request->validated();
        $student = Student::find($validated['student_nis'], ['name', 'class', 'major_id', 'major_long_name']);

        if (!$student) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan prestasi",
                "Siswa dengan NIS {$validated['student_nis']} tidak ditemukan",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        $addedImageFiles = FileUploadUtils::getAddedFileUpload($request, 'images');
        $uploadedThumbnailUrl = null;

        if (count($addedImageFiles) > 0) {
            foreach ($addedImageFiles as $addedImageFile) {
                $uploadedThumbnailUrl = CloudinaryUtils::uploadImageFile($addedImageFile['file']);
            }
        }

        if (!$uploadedThumbnailUrl) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan prestasi",
                "Terjadi kesalahan saat mengunggah gambar",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        $achievement = Achievement::create([
            'student_nis' => $validated['student_nis'],
            'student_name' => $student->name,
            'student_class' => $student->class,
            'student_major_id' => $student->major_id,
            'student_major_name' => $student->major_long_name,
            'competition_position' => $validated['competition_position'],
            'competition_name' => $validated['competition_name'],
            'competition_level' => $validated['competition_level'],
            'won_at' => $validated['won_at'],
            'thumbnail_url' => $uploadedThumbnailUrl,
        ]);

        if ($achievement) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menambahkan prestasi",
                "Prestasi berhasil ditambahkan",
                $request->session(),
            );
            return redirect()->route('admin.achievement');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan prestasi",
                "Prestasi gagal ditambahkan",
                $request->session(),
            );
            return back()->withInput($validated);
        }
    }

    public function detailAchievement(Achievement $achievement)
    {
        $students = Student::all(['nis', 'name', 'class', 'major_id', 'major_long_name']);
        $competitionPositions = [
            "Juara 1" => 'grade_1',
            "Juara 2" => 'grade_2',
            "Juara 3" => 'grade_3',
        ];
        $competitionLevels = [
            "Sekolah" => 'school',
            "Kecamatan" => 'subdistrict',
            "Kota" => 'district',
            "Provinsi" => 'provincial',
            "Nasional" => 'national',
            "International" => 'international',
        ];

        return view('admin.achievement.detail', compact('achievement', 'students', 'competitionPositions', 'competitionLevels'));
    }

    public function updateAchievement(UpdateAchievementRequest $request, Achievement $achievement)
    {
        $validated = $request->validated();

        if ($validated['student_nis']) {
            $student = Student::find($validated['student_nis'], ['name', 'class', 'major_id', 'major_long_name']);

            if (!$student) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal mengubah prestasi",
                    "Siswa dengan NIS {$validated['student_nis']} tidak ditemukan",
                    $request->session(),
                );
                return back()->withInput($validated);
            }

            $achievement->student_nis = $validated['student_nis'];
            $achievement->student_name = $student->name;
            $achievement->student_class = $student->class;
            $achievement->student_major_id = $student->major_id;
            $achievement->student_major_name = $student->major_long_name;
        }

        $addedImageFiles = FileUploadUtils::getAddedFileUpload($request, 'images');

        if (count($addedImageFiles) > 0) {
            foreach ($addedImageFiles as $addedImageFile) {
                $thumbnailPublicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($achievement->thumbnail_url);
                if (!$thumbnailPublicId) {
                    AlertDataGenerator::generateAsFlashToSession(
                        AlertType::DANGER,
                        "Gagal mengubah prestasi",
                        "Terjadi kesalahan saat menghapus gambar lama (public id tidak ditemukan)",
                        $request->session(),
                    );
                    return back()->withInput($validated);
                }

                $uploadedUrl = CloudinaryUtils::replaceImageFile(
                    $addedImageFile['file'],
                    $thumbnailPublicId
                );
                if (!$uploadedUrl) {
                    AlertDataGenerator::generateAsFlashToSession(
                        AlertType::DANGER,
                        "Gagal mengubah prestasi",
                        "Terjadi kesalahan saat mengunggah gambar baru",
                        $request->session(),
                    );
                    return back()->withInput($validated);
                }

                $achievement->thumbnail_url = $uploadedUrl;
            }
        }

        $achievement->competition_position = $validated['competition_position'];
        $achievement->competition_name = $validated['competition_name'];
        $achievement->competition_level = $validated['competition_level'];
        $achievement->won_at = $validated['won_at'];

        $isUpdated = $achievement->save();

        if ($isUpdated) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengubah prestasi",
                "Prestasi berhasil diubah",
                $request->session(),
            );
            return redirect()->route('admin.achievement');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengubah prestasi",
                "Prestasi gagal diubah",
                $request->session(),
            );
            return back()->withInput($validated);
        }
    }

    public function deleteAchievement(Request $request, Achievement $achievement)
    {
        $thumbnailPublicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($achievement->thumbnail_url);
        if (!$thumbnailPublicId) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus prestasi",
                "Terjadi kesalahan saat menghapus gambar prestasi (public id tidak ditemukan)",
                $request->session(),
            );
            return back();
        }

        $isImageDeleted = CloudinaryUtils::deleteImageFile($thumbnailPublicId);
        if (!$isImageDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus prestasi",
                "Terjadi kesalahan saat menghapus gambar prestasi",
                $request->session(),
            );
            return back();
        }

        $isDeleted = $achievement->delete();
        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus prestasi",
                "Berhasil menghapus prestasi dari siswa \"$achievement->student_name\"",
                $request->session(),
            );
            return redirect()->route('admin.achievement');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus prestasi",
                "Gagal menghapus prestasi dari siswa \"$achievement->student_name\"",
                $request->session(),
            );
            return back();
        }
    }
}
