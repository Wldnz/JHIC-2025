<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function galleries()
    {
        return view('user.galleries');
    }

    public function facilities()
    {
        return view('user.facilities');
    }
}
