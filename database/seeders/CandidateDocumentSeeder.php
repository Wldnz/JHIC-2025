<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Utilities\StorageUtils;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class CandidateDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeholderDirectory = 'candidate-documents';
        $requiredDocuments = [
            [
                'name' => 'Akte Kelahiran',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/Akte Kelahiran.pdf"),
                'mime_types' => 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
            [
                'name' => 'FC Ijazah SLTP/MTs di Legalisir',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/FC Ijazah SLTP - MTs di Legalisir.pdf"),
                'mime_types' => 'image/*,application/pdf',
            ],
            [
                'name' => 'FC Raport Kelas III Smt. 5 - 6 di Legalisir',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/FC Raport Kelas III Smt. 5 - 6 di Legalisir.pdf"),
                'mime_types' => 'image/*,application/pdf',
            ],
            [
                'name' => 'FC SKHUN SLTP/MTs di Legalisir',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/FC SKHUN SLTP - MTs di Legalisir.pdf"),
                'mime_types' => 'image/*,application/pdf',
            ],
            [
                'name' => 'Kartu Keluarga',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/Kartu Keluarga.pdf"),
                'mime_types' => 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
            [
                'name' => 'Surat Keterangan Catatan Kepolisian (SKCK)',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/Surat Keterangan Catatan Kepolisian (SKCK).pdf"),
                'mime_types' => 'application/pdf',
            ],
            [
                'name' => 'Surat Keterangan Kelakuan Baik dari Sekolah',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/Surat Keterangan Kelakuan Baik dari Sekolah.pdf"),
                'mime_types' => 'application/pdf',
            ],
            [
                'name' => 'Surat Keterangan Sehat / Dokter',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/Surat Keterangan Sehat - Dokter.pdf"),
                'mime_types' => 'application/pdf',
            ],
            [
                'name' => 'Surat Orang Tua / Wali Peserta Didik',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/Surat Orang Tua - Wali Peserta Didik.pdf"),
                'mime_types' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
            [
                'name' => 'Surat Pernyataan Peserta Didik',
                'file_path' => Storage::disk('local')->path("$placeholderDirectory/Surat Pernyataan Peserta Didik.pdf"),
                'mime_types' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
        ];
        $candidates = Candidate::query()->inRandomOrder()->limit(10)->get();

        foreach ($candidates as $candidate) {
            $randomRequiredDocuments = fake()->randomElements($requiredDocuments, fake()->numberBetween(1, count($requiredDocuments)));
            foreach ($randomRequiredDocuments as $documentData) {
                $candidateDocument = StorageUtils::uploadNewCandidateDocument(
                    $candidate,
                    $documentData['name'],
                    $documentData['mime_types'],
                    File::get($documentData['file_path'])
                );

                echo "Candidate NISN: {$candidate->nisn},\tDocument: {$candidateDocument->name},\tFile URL: {$candidateDocument->file_url}\n";
            }
        }
    }
}
