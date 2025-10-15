<?php
namespace App\Utilities;

use App\Helpers\GdriveFileInfo;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class StorageUtils
{
    public static $articlesDir = 'articles';
    public static $registrationDocumentsDir = 'registration-documents';
    public static $candidateDocumentsDir = 'candidate-documents';

    public static function uploadCandidateDocument(CandidateDocument $candidateDocument, string $fileContent)
    {
        try {
            $encryptedFileContent = Crypt::encrypt($fileContent);
            Storage::disk('google')->put(
                $candidateDocument->file_url,
                $encryptedFileContent
            );
            return true;
        } catch (Throwable $e) {
            logger()->error($e);
            report($e);
            return false;
        }
    }

    public static function getCandidateDocument(CandidateDocument $candidateDocument)
    {
        try {
            $data = Gdrive::get($candidateDocument->file_url);
            $encryptedFileContent = Crypt::decrypt($data->file);

            return new GdriveFileInfo(
                $encryptedFileContent,
                $data->ext,
                $data->filename
            );
        } catch (Throwable $e) {
            logger()->error($e);
            report($e);
            return null;
        }
    }
}
