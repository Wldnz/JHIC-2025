<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = [
        'id',
        'user_nis',
        'received_email',
        'received_phone',
        'total_product',
        'total_price',
        'expired',
        'sttus'
    ];
}
