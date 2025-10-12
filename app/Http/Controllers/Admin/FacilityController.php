<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFacilityRequest;
use App\Http\Requests\Admin\UpdateFacilityRequest;
use App\Models\Gallery;
use App\Models\GalleryType;
use App\Utilities\AlertDataGenerator;
use App\Utilities\CloudinaryUtils;
use App\Utilities\FileUploadUtils;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    protected $maxPage = 4;

    public function facility(Request $request)
    {
        $search = $request->get('search', '');
        $search_status = $request->get('search_status', '');
        $page =  $request->get('page', 1);

        $max = $this->maxPage;
        $facilities = Gallery::query()
            ->select(['id', 'url', 'name', 'description', 'gallery_type_name']);

        $stats = [
            "total" => $facilities->get()->count(),
        ];

        if ($search) {
            $facilities = $facilities
                ->where('name', 'like', "%$search%")
                ->orWhere('gallery_type_name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        if ($search_status) {
            $facilities = $facilities
                ->where('status', '=', $search_status);
        }

        $total = $facilities->count();
        $facilities = $facilities
            ->limit($this->maxPage)
            ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.facility.index',compact('facilities', 'search', 'search_status', 'page', 'total', 'stats', 'max'));
    }

    public function createFacility()
    {
        $availableFacilityTypes = GalleryType::all(['id', 'name']);
        return view('admin.facility.create', compact('availableFacilityTypes'));
    }

    public function storeFacility(StoreFacilityRequest $request)
    {
        $validated = $request->validated();
        $galleryType = GalleryType::find($validated['type']);

        if (!$galleryType) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan fasilitas",
                "Gagal menemukan tipe fasilitas dengan id ({$validated['type']}) didalam database",
                $request->session()
            );
            return back()->withInput($validated);
        }

        $addedFileData = FileUploadUtils::getAddedFileUpload($request, 'images');
        $uploadedUrl = null;

        foreach ($addedFileData as $fileData) {
            if ($uploadedUrl) break;

            $uploadedUrl = CloudinaryUtils::uploadImageFile($fileData['file']);
            if (!$uploadedUrl) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal menambahkan fasilitas",
                    "Gagal mengupload gambar fasilitas",
                    $request->session()
                );
                return back()->withInput($validated);
            }
        }

        $gallery = Gallery::create([
            'name' => $validated['title'],
            'url' => $uploadedUrl,
            'description' => $validated['description'],
            'media_type' => 'image',
            'gallery_type_id' => $galleryType->id,
            'gallery_type_name' => $galleryType->name,
        ]);

        if ($gallery) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menambahkan fasilitas",
                "Berhasil menambahkan data fasilitas dengan nama \"{$validated['title']}\"",
                $request->session()
            );
            return redirect()->route('admin.facility');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan fasilitas",
                "Gagal menambahkan data fasilitas dengan nama \"{$validated['title']}\"",
                $request->session()
            );
            return back()->withInput($validated);
        }
    }

    public function detailFacility(Gallery $facility)
    {
        $availableFacilityTypes = GalleryType::all(['id', 'name']);
        return view('admin.facility.detail', compact('facility', 'availableFacilityTypes'));
    }

    public function updateFacility(UpdateFacilityRequest $request, Gallery $facility)
    {
        $validated = $request->validated();
        $galleryType = GalleryType::find($validated['type']);

        if (!$galleryType) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate fasilitas",
                "Gagal menemukan tipe fasilitas dengan id ({$validated['type']}) didalam database",
                $request->session()
            );
            return back()->withInput($validated);
        }

        $updatedFileData = FileUploadUtils::getUpdatedFileUpload($request, 'images');
        $uploadedUrl = null;

        foreach ($updatedFileData as $fileData) {
            if ($uploadedUrl) break;

            $publicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($facility->url);
            if (!$publicId) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal mengupdate fasilitas",
                    "Gagal menghapus gambar fasilitas lama (public id tidak ditemukan)",
                    $request->session()
                );
                return back()->withInput($validated);
            }

            $uploadedUrl = CloudinaryUtils::replaceImageFile($fileData['file'], $publicId);
            if (!$uploadedUrl) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Gagal mengupdate fasilitas",
                    "Gagal mengupload gambar fasilitas yang baru",
                    $request->session()
                );
                return back()->withInput($validated);
            }

            $facility->url = $uploadedUrl;
        }

        $isUpdated = $facility->update([
            'name' => $validated['title'],
            'description' => $validated['description'],
            'media_type' => 'image',
            'gallery_type_id' => $galleryType->id,
            'gallery_type_name' => $galleryType->name,
        ]);

        if ($isUpdated) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengupdate fasilitas",
                "Berhasil mengupdate data fasilitas dengan nama \"{$validated['title']}\"",
                $request->session()
            );
            return redirect()->route('admin.facility');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate fasilitas",
                "Gagal mengupdate data fasilitas dengan nama \"{$validated['title']}\"",
                $request->session()
            );
            return back()->withInput($validated);
        }
    }

    public function deleteFacility(Request $request, Gallery $facility)
    {
        $publicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($facility->url);
        if (!$publicId) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus fasilitas",
                "Gagal menghapus gambar fasilitas lama (public id tidak ditemukan)",
                $request->session()
            );
            return back();
        }

        $isImageDeleted = CloudinaryUtils::deleteImageFile($publicId);
        if (!$isImageDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus fasilitas",
                "Gagal menghapus gambar fasilitas lama",
                $request->session()
            );
            return back();
        }

        $isDeleted = $facility->delete();
        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus fasilitas",
                "Berhasil menghapus data fasilitas dengan nama \"$facility->name\"",
                $request->session()
            );
            return redirect()->route('admin.facility');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus fasilitas",
                "Gagal menghapus data fasilitas dengan nama \"$facility->name\"",
                $request->session()
            );
            return back();
        }
    }
}
