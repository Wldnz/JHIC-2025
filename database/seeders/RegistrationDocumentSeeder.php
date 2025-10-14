<?php

namespace Database\Seeders;

use App\Models\RegistrationDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dateNow = now();
        RegistrationDocument::query()->insert([
            [
                'name' => 'Surat Pernyataan Peserta Didik',
                'mime_types' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Orang Tua / Wali Peserta Didik',
                'mime_types' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Akta Kelahiran',
                'mime_types' => 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Kartu Keluarga',
                'mime_types' => 'image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Keterangan Sehat / Dokter',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Keterangan Kelakuan Baik dari Sekolah',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'Surat Keterangan Catatan Kepolisian (SKCK)',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'FC Raport Kelas III Smt. 5 - 6 di Legalisir',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'FC Ijazah SLTP/MTs di Legalisir',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
            [
                'name' => 'FC SKHUN SLTP/MTs di Legalisir',
                'mime_types' => 'application/pdf',
                'is_required' => true,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ],
        ]);
    }
}
