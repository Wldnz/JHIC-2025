<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\OrderTransactionFactory> */
    use HasFactory;
    protected $table = 'order_transaction';
    protected $fillable = [
        'id',
        'transaction_id',
        'product_variant_id',
        'quantity',
        'price'
    ];
}
