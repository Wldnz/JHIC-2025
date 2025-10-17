<?php

namespace Database\Seeders;

use App\Models\RegistrationDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class RegistrationDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseDir = "registration-documents";
        $registrationDocumentFilePaths = [
            "$baseDir/Surat Pernyataan Peserta Didik.docx",
            "$baseDir/Surat Orang Tua - Wali Peserta Didik.pdf",
            "$baseDir/Formulir Biodata.pdf",
        ];

        foreach ($registrationDocumentFilePaths as $registrationDocumentFilePath) {
            Gdrive::put(
                $registrationDocumentFilePath,
                Storage::disk('local')->path($registrationDocumentFilePath)
            );
        }

        $dateNow = now();
        RegistrationDocument::query()->insert([
            [
                'name' => 'Surat Pernyataan Peserta Didik',
                'mime_types' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'download_file_url' => Storage::disk('google')->url($registrationDocumentFilePaths[0]),
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Orang Tua / Wali Peserta Didik',
                'mime_types' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'download_file_url' => Storage::disk('google')->url($registrationDocumentFilePaths[1]),
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Formulir Biodata',
                'mime_types' => 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'download_file_url' => Storage::disk('google')->url($registrationDocumentFilePaths[2]),
                'type' => 'form',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Akte Kelahiran',
                'mime_types' => 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Kartu Keluarga',
                'mime_types' => 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Keterangan Sehat / Dokter',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Keterangan Kelakuan Baik dari Sekolah',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Keterangan Catatan Kepolisian (SKCK)',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'FC Raport Kelas III Smt. 5 - 6 di Legalisir',
                'mime_types' => 'image/*,application/pdf',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'FC Ijazah SLTP/MTs di Legalisir',
                'mime_types' => 'image/*,application/pdf',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'FC SKHUN SLTP/MTs di Legalisir',
                'mime_types' => 'image/*,application/pdf',
                'is_required' => true,
                'download_file_url' => null,
                'type' => 'usm',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
        ]);
    }
}
