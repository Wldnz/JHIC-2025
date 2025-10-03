<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Throwable;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transactions';
    protected $fillable = [
        'user_nis',
        'user_fullname',
        'received_email',
        'received_phone',
        'total_product',
        'total_price',
        'payment_method',
        'created_at',
        'expired_at',
        'received_at',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_nis', 'nis');
    }

    public function orders()
    {
        return $this->hasMany(OrderTransaction::class, 'transaction_id', 'id');
    }

    public function firstOrder()
    {
        return $this->orders->first();
    }

    public function midtransTransaction()
    {
        return $this->hasOne(MidtransTransaction::class, 'self_order_id', 'id');
    }

    public function refreshStatus(bool $setToOngoing = false, bool $setToFail = false) {
        if ($this->status == 'success') return true;

        if ($setToFail) {
            $this->status = 'fail';
            $isSaved = $this->save();
            return $isSaved;
        }

        $isDBTransactionActive = DB::transactionLevel() > 0;
        if ($isDBTransactionActive) DB::beginTransaction();

        try {

            $this->load('orders', 'orders.product_variant');

            $isPreOrder = false;
            $resultTransactionStatus = ($setToOngoing || $this->status == 'ongoing') ? 'ongoing' : 'pending';
            $numOfNotSuccess = count($this->orders->toArray());

            if ($setToOngoing) $this->orders->each(function ($order) use (&$resultTransactionStatus, &$isPreOrder, &$numOfNotSuccess) {
                if ($order->recevied_quantity >= $order->quantity) {
                    $order->status = 'success';
                    $numOfNotSuccess--;

                    return;
                }

                $decrementQty = $order->product_variant->stock > $order->quantity ? $order->quantity : $order->product_variant->stock;

                $order->product_variant->stock -= $decrementQty;
                $order->recevied_quantity += $decrementQty;

                if ($order->recevied_quantity >= $order->quantity) {
                    $order->status = 'success';
                    $numOfNotSuccess--;
                } else if ($order->product_variant->stock >= ($order->quantity - $order->recevied_quantity)) {
                    $order->status = 'ongoing';
                } else {
                    $order->status = 'preorder';
                    $isPreOrder = true;
                }

                $isSaved = $order->save();
                if (!$isSaved) {
                    throw new Exception('Terjadi kesalahan saat update stock');
                }

                $isSaved = $order->product_variant->save();
                if (!$isSaved) {
                    throw new Exception('Terjadi kesalahan saat update stock');
                }

            });

            $resultTransactionStatus = $numOfNotSuccess <= 0 ? 'success' : $resultTransactionStatus;
            $this->status = $isPreOrder ? 'preorder' : $resultTransactionStatus;

            if ($this->status == 'success') {
                $this->received_at = now();
            }

            $isSaved = $this->save();
            if (!$isSaved) {
                throw new Exception('Terjadi kesalahan saat update status transaksi');
            }

            if ($isDBTransactionActive) DB::commit();
            return true;

        } catch (Throwable $th) {
            if ($isDBTransactionActive) DB::rollback();
            report($th);
            logger()->error($th);

            return false;

        }
    }
}
