<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Major;
use App\Models\RegistrationPhase;
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

        $initiliazeAccounts = User::all();

        $stats = [
            'total' => $initiliazeAccounts->count(),
            'candidate' => $initiliazeAccounts->where('role', '=','candidate')->count(),
            'article Creator' => $initiliazeAccounts->where('role', '=','article_creator')->count(),
            'admin' => $initiliazeAccounts->where('role', '=','admin')->count(),
            'owner' => $initiliazeAccounts->where('role', '=','super_admin')->count(),
        ];

        $accounts = User::query()
            ->select(['id', 'fullname', 'email', 'phone', 'role', 'created_at']);

        if ($search) {
            $accounts = $accounts
                ->where('fullname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        if ($search_role) {
            $accounts = $accounts->where('role', '=', $search_role);
        }

        $total = $accounts->get()->count();
        $accounts = $accounts->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.accounts.index', compact('accounts','stats', 'search', 'search_role', 'page', 'total'));
    }

    public function createAccount()
    {
        return view('admin.accounts.create');
    }

    public function storeAccount(Request $request)
    {
        return back();
    }

    public function detailAccount(User $account)
    {
        $candidate = null;
        $majors = null;
        $phases = null;
        $articles = null;
        if($account->role == 'candidate'){
            $candidate = Candidate::all()
            ->load([
                'user',
                'registrationPhase',
                'registrationSource',
                'candidateMajors',
                'candidateGuardian',
                'candidateDocuments',
                'transactions'
            ])
            ->where('user_id', '=', $account->id)
            ->first();
            $majors = Major::all();
            $phases = RegistrationPhase::all();
        }else if($account->role == 'article_creator'){
            $articles = null;
        }
        return view('admin.accounts.detail', compact('account', 'candidate', 'majors', 'phases', 'articles'));
    }

    public function updateAccount(Request $request, $account)
    {
        return back();
    }

    public function deleteAccount($account)
    {
        return back();
    }

    public function resetPassword($account){
        return back();
    }
}
