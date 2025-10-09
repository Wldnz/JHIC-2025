<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MidtransTransaction extends Model
{
    protected $table = 'midtrans_transactions';

    protected $fillable = [
        'id',
        'self_order_id',
        'status_code',
        'status_message',
        'transaction_time',
        'transaction_status',
        'fraud_status',
        'approval_code',
        'gross_amount',
        'payment_type',
        'card_type',
        'payment_option_type',
        'reference_id',
    ];

    public function selfTransaction()
    {
        return $this->belongsTo(Transaction::class, 'self_order_id', 'id');
    }
}
