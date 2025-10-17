<?php

namespace App\Http\Controllers;

use App\Models\MidtransTransaction;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Spatie\Async\Pool;
use Throwable;

class MidtransController extends Controller
{
    public function paymentNotification(Request $request) {
        $data = $request->all();
        $pool = Pool::create();

        $pool[] = async(function () use ($data) {
            // $transaction = MidtransTransaction::create([
            //     'id' => $data['transaction_id'],
            //     'self_order_id' => str_ireplace('BITU-TRX ', '', $data['order_id']),
            //     'status_code' => $data['status_code'],
            //     'status_message' => $data['status_message'],
            //     'transaction_time' => $data['transaction_time'],
            //     'transaction_status' => $data['transaction_status'],
            //     'fraud_status' => $data['fraud_status'],
            //     'approval_code' => $data['approval_code'],
            //     'gross_amount' => $data['gross_amount'],
            //     'payment_type' => $data['payment_type'],
            //     'card_type' => $data['card_type'],
            //     'payment_option_type' => $data['payment_option_type'],
            //     'reference_id' => $data['reference_id'],
            // ]);
            $transaction = Transaction::query()
                ->where('snap_id', '=', $data['order_id'])
                ->first();

            if (!$transaction) {
                report($transaction);
                logger()->error($transaction);
                throw new Exception("Transaksi dengan ID {$data['order_id']} tidak ditemukan");
            }

            $transaction->status = $data['transaction_status'];
            $isSaved = $transaction->save();

            if (!$isSaved) {
                report($transaction);
                logger()->error($transaction);
                throw new Exception("Terjadi kesalahan saat menyimpan transaksi");
            }

            // if (!$midtransTransaction) {
            //     throw new Exception("Terjadi kesalahan saat menambahkan transaksi Midtrans");
            // }

            // if ($data['transaction_status'] == 'settlement') {
            //     $midtransTransaction->selfTransaction->refreshStatus(setToOngoing: true, setToFail: false);
            // } else {
            //     $midtransTransaction->selfTransaction->refreshStatus(setToFail: true);
            // }

        })->catch(function (Throwable $th) {
            report($th);
            logger()->error($th);
        });

        return response();
    }
}
