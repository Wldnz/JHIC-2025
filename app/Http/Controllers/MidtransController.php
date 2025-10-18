<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Spatie\Async\Pool;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MidtransController extends Controller
{
    public function paymentNotification(Request $request) {
        $data = $request->all();
        $pool = Pool::create();

        $pool[] = async(function () use ($data) {
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

        })->then(function () use ($data) {
            logger("Transaksi dengan ID {$data['order_id']} berhasil disimpan");
        })->catch(function (Throwable $th) {
            report($th);
            logger()->error($th);
        });



        return response('', Response::HTTP_NO_CONTENT);
    }
}
