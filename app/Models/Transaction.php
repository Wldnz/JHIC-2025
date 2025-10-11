<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'candidate_nisn',
        'candidate_full_name',
        'payment_method_id',
        'payment_method_display_name',
        'total_cost',
        'expired_at',
        'status',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Get the candidate that owns the transaction.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the payment method that owns the transaction.
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
