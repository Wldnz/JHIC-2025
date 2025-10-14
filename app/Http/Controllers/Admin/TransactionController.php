<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTransactionRequest;
use App\Models\Candidate;
use App\Models\PaymentMethod;
use App\Models\Student;
use App\Models\Transaction;
use App\Utilities\AlertDataGenerator;
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
            'success' => $initiliazeTrasanctions->where('status', '=', 'settlement'),
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

    public function detailTransaction(Transaction $transaction)
    {
        return view('admin.transactions.detail', compact('transaction'));
    }

    public function storeTransactionPage()
    {
        $candidates = Candidate::all(['nisn', 'full_name']);
        $payments = PaymentMethod::all();

        return view('admin.transactions.create', compact('candidates', 'payments'));
    }

    public function storeTransaction(StoreTransactionRequest $request)
    {
        $validated = $request->validated();

        $candidate = Candidate::find($validated['candidate_nisn']);
        if (!$candidate) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan transaksi",
                "Calon siswa dengan NISN {$validated['candidate_nisn']} tidak ditemukan",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        $payment = PaymentMethod::firstWhere('code_name', '=', $validated['payment_method']);
        if (!$payment) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan transaksi",
                "Metode pembayaran dengan code {$validated['payment_method']} tidak ditemukan",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        $transaction = Transaction::create([
            'candidate_nisn' => $candidate->nisn,
            'candidate_full_name' => $candidate->full_name,
            'payment_method_id' => $payment->id,
            'payment_method_display_name' => $payment->display_name,
            'total_cost' => $validated['total_cost'],
            'expired_at' => now()->addHours(24),
            'status' => $validated['has_paid'] ? 'settlement' : 'pending',
        ]);

        if ($transaction) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menambahkan transaksi",
                "Transaksi oleh calon siswa ber-NISN {$validated['candidate_nisn']} berhasil ditambahkan",
                $request->session(),
            );
            return redirect()->route('admin.transactions');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan transaksi",
                "Transaksi oleh calon siswa ber-NISN {$validated['candidate_nisn']} gagal ditambahkan",
                $request->session(),
            );
            return back()->withInput($validated);
        }
    }

    public function updateTransaction(Request $request, Transaction $transaction)
    {
        // handle update later
        return back();
    }

    public function deleteTransaction(Request $request, Transaction $transaction)
    {
        $isDeleted = $transaction->delete();
        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus transaksi",
                "Transaksi oleh calon siswa ber-NISN {$transaction->candidate_nisn} berhasil dihapus",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus transaksi",
                "Transaksi oleh calon siswa ber-NISN {$transaction->candidate_nisn} gagal dihapus",
                $request->session(),
            );
        }
        return back();
    }
}
