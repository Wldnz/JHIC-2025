<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'id',
        'user_nis',
        'variant_product_id',
        'quantity',
    ];

    public function variantProduct(){
        return $this->belongsTo(ProductVariant::class, 'variant_product_id');
    }

}
