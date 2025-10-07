<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view('candidate.index');
    }

    public function dashboard()
    {
        return view('candidate.dashboard');
    }

    public function schedule()
    {
        return view('candidate.schedule');
    }

    public function contact()
    {
        return view('candidate.contact');
    }

    public function learningMaterials()
    {
        return view('candidate.learning-materials');
    }
}
