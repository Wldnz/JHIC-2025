<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreDocumentRequest;
use App\Models\Candidate;
use App\Models\Major;
use App\Models\PaymentMethod;
use App\Models\RegistrationDocument;
use App\Models\RegistrationPhase;
use App\Models\RegistrationSource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use Illuminate\Validation\Rules\File;

class StageController extends Controller
{
    public function stage1()
    {
        $payments = PaymentMethod::where('is_enabled', '=', '1')->get();
        return view('candidate.stage.stage-1', compact( 'payments'));
    }

    public function saveStage1(Request $request)
    {    dd($request);
        return view('candidate.stage.stage-1-saved');
    }

    public function stage2()
    {
        return view('candidate.stage.stage-2');
    }

    public function saveStage2(Request $request)
    {
        return view('candidate.stage.stage-2-saved');
    }

    public function stage3()
    {
        $phases = RegistrationPhase::all();
        $sources = RegistrationSource::all();
        return view('candidate.stage.stage-3', compact( 'phases', 'sources'));
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
        $payments = PaymentMethod::where('is_enabled', '=', '1')->get();
        return view('candidate.stage.stage-4', compact( 'payments'));
    }

    public function saveStage4()
    {
        return view('candidate.stage.stage-4-saved');
    }

    public function stage5()
    {   $documents = RegistrationDocument::all();
        return view('candidate.stage.stage-5', compact( 'documents'));
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
