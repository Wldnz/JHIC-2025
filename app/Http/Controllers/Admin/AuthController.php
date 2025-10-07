<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // handle login logic here later
        return back();
    }

    public function logout()
    {
        // handle logout logic here later
        return redirect()->route('admin.login-page');
    }
}
