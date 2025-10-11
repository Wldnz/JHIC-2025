<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $maxPage = 10;
    public function accounts(Request $request)
    {

        $search = $request->get('search', '');
        $search_role = $request->get('search_role', 'candidate');
        $page =  $request->get('page', 1);

        $accounts = User::select();
        if($search){
            $accounts = $accounts->where('fullname', '=', $search)
                ->orWhere('fullname', 'like', '%'.$search.'%');
        }
        if($search_role){
            $accounts = $accounts->where('role', '=', $search_role);
        }
        $total = $accounts->get()->count();
        $accounts = $accounts->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.accounts.index', compact('accounts', 'search', 'search_role', 'page', 'total'));
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
