<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function settings()
    {
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        // handle update logic later
        return back();
    }
}
