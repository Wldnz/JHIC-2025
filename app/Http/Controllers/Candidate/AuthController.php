<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Auth;
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
        if (Auth::check()) return redirect()->route('candidate.dashboard');
        return view('candidate.auth.login');
    }

    public function login(Request $request)
    {
       $validated = $request->validate([
            'email' => 'required|email|min:8',
            'password' => 'required|string|min:8'
        ]);

        if (Auth::attempt($validated, true)) {
            $request->session()->regenerate();
            return redirect()->route('candidate.dashboard');
        }
        
        return back()->withInput($validated);
    }

    public function logout()
    {
        return redirect()->route('candidate.login-page');
    }
}
