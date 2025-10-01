<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = 'payment_types';

    protected $fillable = [
        'display_name',
        'code_name',
        'icon_url',
        'is_enable',
    ];
}
