<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MajorsController extends Controller
{
    public function animation()
    {
        return view('user.majors.animation');
    }

    public function broadcasting()
    {
        return view('user.majors.broadcasting');
    }

    public function visualCommunicationDesign()
    {
        return view('user.majors.visual-communication-design');
    }

    public function softwareEngineering()
    {
        return view('user.majors.software-engineering');
    }

    public function networkEngineering()
    {
        return view('user.majors.network-engineering');
    }

    public function gameDevelopment()
    {
        return view('user.majors.game-development');
    }
}
