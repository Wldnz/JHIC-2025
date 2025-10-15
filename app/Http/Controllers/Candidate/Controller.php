<?php

namespace App\Http\Controllers\Candidate;

use App\Models\Candidate;
use Auth;
use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Controller
{

    protected $candidate = null;

    public function __construct(){
        if(Auth::check() && Auth::user()->role == 'candidate'){
            $candidate = Candidate::where('user_id', '=', Auth::user()->id)
                ->get();
        }
    }

    public function index()
    {
        return view('candidate.index');
    }

    public function dashboard()
    {
        $candidate = $this->candidate;
        return view('candidate.dashboard', compact('candidate'));
    }

    public function schedule()
    {
        $candidate = $this->candidate;
        return view('candidate.schedule', compact('candidate'));
    }

    public function contact()
    {
        $candidate = $this->candidate;
        return view('candidate.contact', compact('candidate'));
    }

    public function learningMaterials()
    {
        $candidate = $this->candidate;
        return view('candidate.learning-materials', compact('candidate'));
    }
}
