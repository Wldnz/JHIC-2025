<?php
namespace App\Utilities;

use App\Helpers\GdriveFileInfo;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Models\RegistrationPhase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class StorageUtils
{
    public static $articlesDir = 'articles';
    public static $registrationDocumentsDir = 'registration-documents';
    public static $candidateDocumentsDir = 'candidate-documents';

    public static function uploadNewCandidateDocument(Candidate $candidate, string $fileName, string $fileMimetypes, string $fileContent, bool $isValid = false, string $documentType = 'usm')
    {
        try {
            $currentTimestamps = microtime(true);
            $gdrivePath = self::$candidateDocumentsDir . "/{$candidate->nisn}/{$currentTimestamps}.pdf";
            $encryptedFileContent = Crypt::encrypt($fileContent);

            Storage::disk('google')->put(
                $gdrivePath,
                $encryptedFileContent
            );

            $isUsingRegistrationPhase = false;
            if (!$candidate->registrationPhase()->count() > 0) {
                $oldestRegistrationPhase = RegistrationPhase::query()
                    ->orderBy('ended_at', 'desc')
                    ->first();

                $isUsingRegistrationPhase = (
                    $oldestRegistrationPhase &&
                    now() >= Carbon::parse($oldestRegistrationPhase->ended_at)
                );
            } else {
                $isUsingRegistrationPhase = false;
            }

            return CandidateDocument::create([
                'candidate_nisn' => $candidate->nisn,
                'user_id' => $candidate->user_id,
                'name' => $fileName,
                'mime_types' => $fileMimetypes,
                'file_url' => $gdrivePath,
                'is_valid' => $isValid,
                'expired_at' => $isUsingRegistrationPhase ?
                    Carbon::parse($candidate->registrationPhase->ended_at)->addDays(5) :
                    now()->addDays(5),
                'type' => $documentType,
            ]);
        } catch (Throwable $e) {
            logger()->error($e);
            report($e);
            return null;
        }
    }

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

    public static function deleteAllCandidateDocuments(Candidate $candidate)
    {
        try {
            $gdrivePath = self::$candidateDocumentsDir . "/{$candidate->nisn}";
            Gdrive::deleteDir($gdrivePath);
            return true;
        } catch (Throwable $e) {
            logger()->error($e);
            report($e);
            return false;
        }
    }
}
