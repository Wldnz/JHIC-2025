<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signupPage()
    {
        return view('admin.auth.signup');
    }

    public function signup(Request $request)
    {
        // handle signup logic here later
        return back();
    }

    public function loginPage()
    {
        if (Auth::check()) return redirect()->route('admin.dashboard');
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|min:8',
            'password' => 'required|string|min:8'
        ]);

        if (Auth::attempt($validated, true)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withInput($validated);
    }

    public function logout(Request $request)
    {   
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login-page');
    }
}
