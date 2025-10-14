<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function saveStage5()
    {
        return view('candidate.stage.stage-5-saved');
    }
}
