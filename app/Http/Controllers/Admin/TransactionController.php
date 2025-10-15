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

        $transactionStats = Transaction::query()
            ->selectRaw("COUNT(*) AS total")
            ->selectRaw("COUNT(CASE WHEN status = 'settlement' THEN 1 END) AS success")
            ->selectRaw("COUNT(CASE WHEN status = 'refund' THEN 1 END) AS refund")
            ->selectRaw("COUNT(CASE WHEN status = 'cancel' THEN 1 END) AS canceled")
            ->selectRaw("COUNT(CASE WHEN status = 'expired' THEN 1 END) AS expired")
            ->first();

        $transactions = Transaction::query();
        $stats = [
            'total' => $transactionStats->total,
            'success' => $transactionStats->success,
            'refund' => $transactionStats->refund,
            'canceled' => $transactionStats->canceled,
            'expired' => $transactionStats->expired,
        ];
        if($search){
            $transactions = $transactions
                ->where('candidate_nisn', 'like', '%'.$search.'%')
                ->orWhere('candidate_full_name', 'like', '%'.$search.'%')
                ->orWhere('payment_method_display_name', 'like', '%'.$search.'%');
        }
        if($search_status){
            $transactions = $transactions->where('status', '=', $search_status);
        }
        $total = $search || $search_status ? $transactions->count() : $stats['total'];
        $transactions = $transactions
            ->limit($this->maxPage)
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
                "Transaksi oleh calon siswa ber-NISN {$transaction->candidate_nisn} berhasil ditandai sebagai \"Terhapus\"",
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
