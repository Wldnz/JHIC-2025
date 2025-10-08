<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signupPage()
    {
        return view('candidate.auth.signup');
    }

    public function signup(Request $request)
    {
        // logic later
        return back();
    }

    public function loginPage()
    {
        return view('candidate.auth.login');
    }

    public function login(Request $request)
    {
        // logic later
        return back();
    }

    public function logout()
    {
        return redirect()->route('candidate.login-page');
    }
}
