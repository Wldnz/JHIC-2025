<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function accounts()
    {
        return view('admin.accounts.index');
    }

    public function createAccount()
    {
        return view('admin.accounts.create');
    }

    public function storeAccount(Request $request)
    {
        return back();
    }

    public function detailAccount($account)
    {
        return view('admin.accounts.detail', compact('account'));
    }

    public function updateAccount(Request $request, $account)
    {
        return back();
    }

    public function deleteAccount($account)
    {
        return back();
    }
}
