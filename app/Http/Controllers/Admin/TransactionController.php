<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    protected $maxPage = 10;

    public function transactions(Request $request)
    {
        $search = $request->get('search', '');
        $search_status = $request->get('search_status', '');
        $page =  $request->get('page', 1);

        $initiliazeTrasanctions = Transaction::all();
        $transactions = Transaction::select();
        $stats = [
            'total' => $initiliazeTrasanctions->count(),
            'success' => $initiliazeTrasanctions->where('status', '=', 'capture'),
            'refund' => $initiliazeTrasanctions->where('status', '=', 'refund'),
            'canceled' => $initiliazeTrasanctions->where('status', '=', 'canceled'),
            'expired' => $initiliazeTrasanctions->where('status', '=', 'expired')
        ];
        if($search){
            $transactions = $transactions->where('candidate_full_name', '=', $search)
                ->orWhere('candidate_full_name', 'like', '%'.$search.'%');
        }
        if($search_status){
            $transactions = $transactions->where('status', '=', $search_status);
        }
        $total = $transactions->get()->count();
        $transactions = $transactions->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();
        return view('admin.transactions.index', compact('transactions', 'stats','search', 'search_status', 'page', 'total'));
    }

    public function detailTransaction($transaction)
    {
        return view('admin.transactions.detail', compact('transaction'));
    }

    public function storeTransactionPage()
    {
        return view('admin.transactions.create');
    }

    public function storeTransaction(Request $request)
    {
        // handle storing later
        return back();
    }

    public function updateTransaction(Request $request, $transaction)
    {
        // handle update later
        return back();
    }

    public function deleteTransaction($transaction)
    {
        // handle delete later
        return back();
    }
}
