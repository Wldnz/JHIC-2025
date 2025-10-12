<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class Controller extends \App\Http\Controllers\Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function settings()
    {
        $payments = PaymentMethod::all();
        return view('admin.settings.index', compact('payments'));
    }

    public function updateSettings(Request $request)
    {
        // handle update logic later
        return back();
    }
}
