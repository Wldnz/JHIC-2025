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
    protected $candidate = null;

    public function __construct(){
        if(Auth::check() && Auth::user()->role == 'candidate'){
            $candidate = Candidate::where('user_id', '=', Auth::user()->id)
                ->get();
        }
    }
    public function stage1()
    {
        $candidate = $this->candidate;
        $payments = PaymentMethod::where('is_enabled', '=', '1')->get();
        $transactions = Candidate::where('user_id', '=', Auth::user()->id)
        ->get();

        dd($transactions);
        return view('candidate.stage.stage-1', compact('candidate', 'payments'));
    }

    public function saveStage1(Request $request)
    {    dd($request);
        return view('candidate.stage.stage-1-saved', compact('candidate'));
    }

    public function stage2()
    {   $candidate = $this->candidate;
        $transactions = Transaction::where('status', '=', 'success')
            ->orWhere('status', '=', 'settlement')
            // ->where('type', '=', 'form')
            ->get();

        dd($transactions);
        $isPaid = $transactions->isNotEmpty();
        return view('candidate.stage.stage-2', compact('candidate', 'isPaid'));
    }

    public function saveStage2(Request $request)
    {    dd($request);
        return view('candidate.stage.stage-2-saved', compact('candidate'));
    }

    public function stage3()
    {   $candidate = $this->candidate;
        $payments = PaymentMethod::where('is_enabled', '=', '1')->get();
        return view('candidate.stage.stage-3', compact('candidate', 'payments'));
    }

    public function startTransaction()
    {
        return back();
    }

    public function transactionStatus()
    {    $candidate = $this->candidate;
        return view('candidate.stage.transaction-status', compact('candidate'));
    }

    public function stage4()
    {    $candidate = $this->candidate;
        return view('candidate.stage.stage-4', compact('candidate'));
    }

    public function saveStage4()
    {    $candidate = $this->candidate;
        return view('candidate.stage.stage-4-saved', compact('candidate'));
    }

    public function stage5()
    {    $candidate = $this->candidate;
        return view('candidate.stage.stage-5', compact('candidate'));
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
