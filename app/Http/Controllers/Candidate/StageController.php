<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreDocumentRequest;
use App\Models\RegistrationDocument;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use Illuminate\Validation\Rules\File;

class StageController extends Controller
{
    public function stage1()
    {
        return view('candidate.stage.stage-1');
    }

    public function saveStage1()
    {
        return view('candidate.stage.stage-1-saved');
    }

    public function stage2()
    {
        return view('candidate.stage.stage-2');
    }

    public function saveStage2()
    {
        return view('candidate.stage.stage-2-saved');
    }

    public function stage3()
    {
        return view('candidate.stage.stage-3');
    }

    public function startTransaction()
    {
        return back();
    }

    public function transactionStatus()
    {
        return view('candidate.stage.transaction-status');
    }

    public function stage4()
    {
        return view('candidate.stage.stage-4');
    }

    public function saveStage4()
    {
        return view('candidate.stage.stage-4-saved');
    }

    public function stage5()
    {
        return view('candidate.stage.stage-5');
    }

    public function document(RegistrationDocument $registrationDocument)
    {
        if (!$registrationDocument->file_download_url) {
            return response('', 200)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', 'attachment; filename="none"');
        }

        $readStream = Gdrive::readStream($registrationDocument->file_download_url);
        return response()->stream(function() use($readStream) {
            fpassthru($readStream->file);
        }, 200, [
            'Content-Type' => $readStream->ext,
            'Content-Disposition' => "attachment; filename=\"{$readStream->filename}\""
        ]);
    }

    public function saveStage5()
    {
        return view('candidate.stage.stage-5-saved');
    }
}
