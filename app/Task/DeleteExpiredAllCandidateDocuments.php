<?php

namespace App\Task;

use App\Models\CandidateDocument;
use App\Utilities\StorageUtils;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class DeleteExpiredAllCandidateDocuments
{
    public function __invoke()
    {
        $candidateDocuments = CandidateDocument::query()
            ->where('expired_at', '<=', now())
            ->groupBy('candidate_nisn')
            ->get();

        foreach ($candidateDocuments as $candidateDocument) {
            StorageUtils::deleteAllCandidateDocuments($candidateDocument->candidate);
        }

        CandidateDocument::query()
            ->whereIn('candidate_nisn', $candidateDocuments->pluck('candidate_nisn')->toArray())
            ->delete();
    }
}
