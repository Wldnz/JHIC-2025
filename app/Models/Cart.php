<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'id',
        'user_nis',
        'product_variant_id',
        'quantity',
    ];

    public function variantProduct(){
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

}
