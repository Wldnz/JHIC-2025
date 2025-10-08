<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\OrderTransactionFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'order_transactions';
    protected $fillable = [
        'transaction_id',
        'product_variant_id',
        'quantity',
        'price',
        'received_quantity',
        'status',
    ];

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function product_variant(){
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }

    public function productVariant(){
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }

    public function totalPrice(){
        return $this->quantity * $this->product_variant->price;
    }
}
