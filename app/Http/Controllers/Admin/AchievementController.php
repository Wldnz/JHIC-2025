<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAchievementRequest;
use App\Http\Requests\Admin\UpdateAchievementRequest;
use App\Models\Achievement;
use App\Models\Student;
use App\Utilities\AlertDataGenerator;
use App\Utilities\CloudinaryUtils;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function achievement(Request $request)
    {
        $search = $request->query('search', null);
        $major_id = $request->query('major_id', null);

        $achievements = Achievement::query()
            ->orderBy('id', 'asc')
            ->when($search, function ($query, $search) {
                return $query
                    ->where('student_name', 'like', "%{$search}%")
                    ->orWhere('student_class', 'like', "%{$search}%")
                    ->orWhere('student_major_name', 'like', "%{$search}%");
            })
            ->when($major_id, function ($query, $major_id) {
                return $query->where('major_id', "=", $major_id);
            })
            ->get();

        return view('admin.achievement.index', compact('achievements'));
    }

    public function createAchievement()
    {
        $students = Student::all(['nis', 'name', 'class', 'major_name']);
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
        $student = Student::find($validated['student_nis'], ['name', 'class', 'major_id', 'major_name']);

        if (!$student) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan prestasi",
                "Siswa dengan NIS {$validated['student_nis']} tidak ditemukan",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        $uploadedThumbnailUrl = CloudinaryUtils::uploadImageFile($validated['image_file']);

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
            'student_major_name' => $student->major_name,
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
        $students = Student::all(['nis', 'name', 'class', 'major_name']);
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
            $student = Student::find($validated['student_nis'], ['name', 'class', 'major_id', 'major_name']);

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
            $achievement->student_major_name = $student->major_name;
        }

        if ($validated['image_file']) {
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
                $validated['image_file'],
                $achievement->thumbnail_url
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
