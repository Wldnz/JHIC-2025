<?php

namespace App\Http\Controllers\Candidate;

use App\Models\Candidate;
use App\Models\RegistrationDocument;
use App\Models\RegistrationPhase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends \App\Http\Controllers\Controller
{

    protected $candidate = null;

    public function __construct(){
        parent::__construct();
        if(Auth::check() && Auth::user()->role == 'candidate'){
            $this->candidate = Candidate::query()
                ->where('user_id', '=', Auth::user()->id)
                ->first();
        }
    }

    public function index()
    {
        return view('candidate.index');
    }

    public function dashboard()
    {

        $candidate = $this->candidate;
        $currentStage = 1;
        $stopCounting = false;

        $formTransactionCount = Auth::user()->transactions()
            ->where('type', '=', 'form')
            ->where('status', '=', 'settlement')
            ->count();
        $candidate = Auth::user()->candidate()->first();

        if (!$stopCounting && $formTransactionCount > 0 && $candidate) {
            $currentStage = 2;
        } else {
            $stopCounting = true;
            return view('candidate.dashboard', compact('candidate', 'currentStage'));
        }

        $formDocument = $candidate->candidateDocuments()
            ->where('type', '=', 'form')
            ->orderBy('created_at', 'desc')
            ->count();

        if (!$stopCounting && $candidate && $formDocument > 0) {
            $currentStage = 3;
        } else {
            $stopCounting = true;
            return view('candidate.dashboard', compact('candidate', 'currentStage'));
        }

        $candidatePhase = $candidate->candidatePhase()->first();

        if (!$stopCounting && $candidatePhase) {
            $currentStage = 4;
        } else {
            $stopCounting = true;
            return view('candidate.dashboard', compact('candidate', 'currentStage'));
        }

        if (!$stopCounting) {
            $candidateDocuments = $candidate->candidateDocuments()
                ->where('type', '=', 'usm')
                ->get()
                ->pluck('name')
                ->toArray();
            $registrationDocuments = RegistrationDocument::all();

            foreach ($registrationDocuments as $registrationDocument) {
                if (in_array($registrationDocument->name, $candidateDocuments)) {
                    continue;
                }

                $currentStage = 5;
                break;
            }
        }

        return view('candidate.dashboard', compact('candidate', 'currentStage'));
    }

    public function schedule()
    {
        // $candidate = $this->candidate;
        // return view('candidate.schedule', compact('candidate'));
        $registrationPhases = RegistrationPhase::all([
            'name',
            'started_at',
            'ended_at',
        ]);
        return view('candidate.schedule', compact('registrationPhases'));
    }

    public function contact()
    {
        $candidate = $this->candidate;
        return view('candidate.contact', compact('candidate'));
    }

    public function learningMaterials()
    {
        $candidate = $this->candidate;
        $isAllUploads = true;

        if ($candidate) {
            $candidateDocuments = $this->candidate->candidateDocuments()
                ->where('type', '=', 'usm')
                ->get()
                ->pluck('name')
                ->toArray();
            $registrationDocuments = RegistrationDocument::query()
                ->where('type', '=', 'usm')
                ->get();

            foreach ($registrationDocuments as $registrationDocument) {
                if (in_array($registrationDocument->name, $candidateDocuments)) {
                    continue;
                }
                $isAllUploads = false;
                break;
            }
        } else {
            $isAllUploads = false;
        }

        if ($isAllUploads && $candidate) {
            $candidate->load([
                'candidateMajors' => function ($query) {
                    $query
                        ->select(['id', 'candidate_nisn', 'major_long_name'])
                        ->limit(2);
                }
            ]);
        }

        return view('candidate.learning-materials', compact('candidate', 'isAllUploads'));
    }

    public function usmResult()
    {
        $candidate = $this->candidate;
        $isAllUploads = true;

        if ($candidate) {
            $candidateDocuments = $this->candidate->candidateDocuments()
                ->where('type', '=', 'usm')
                ->get()
                ->pluck('name')
                ->toArray();
            $registrationDocuments = RegistrationDocument::query()
                ->where('type', '=', 'usm')
                ->get();

            foreach ($registrationDocuments as $registrationDocument) {
                if (in_array($registrationDocument->name, $candidateDocuments)) {
                    continue;
                }
                $isAllUploads = false;
                break;
            }
        } else {
            $isAllUploads = false;
        }

        if ($isAllUploads && $candidate) {
            $candidate->load([
                'candidateUSMResult',
                'candidateUSMResult.registrationPhase',
            ]);
        }

        return view('candidate.usm-result', compact('candidate', 'isAllUploads'));
    }
}
