<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'id',
        'user_nis',
        'received_email',
        'received_phone',
        'total_product',
        'total_price',
        'payment_method',
        'expired',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_nis', 'nis');
    }

    public function orders(){
        return $this->hasMany(OrderTransaction::class, 'transaction_id', 'id');
    }

    public function firstOrder(){
        return $this->orders->first();
    }
}
