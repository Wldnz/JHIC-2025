<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user()->getAttributes();
        unset($user['password']);
        unset($user['remember_token']);
        return view("admin.dashboard", ["title" => "Dashboard | Bina Tata Usaha", "user" => $user]);
    }

    public function products(){
         $user = Auth::user()->getAttributes();
        unset($user['password']);
        unset($user['remember_token']);
        return view('admin.products',["title" => "Dashboard | Bina Tata Usaha", "user" => $user]);
    }
}
