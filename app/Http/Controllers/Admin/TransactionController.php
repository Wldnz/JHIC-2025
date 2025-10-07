<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transactions()
    {
        return view('admin.transactions.index');
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
