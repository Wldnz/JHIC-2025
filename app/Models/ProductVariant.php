<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use HasFactory;
    protected $table = 'product_variants';
    protected $primaryKey = "nis";
    protected $keyType= "int";

    protected $fillable = [
        'id',
        'product_id',
        'name',
        'type',
        'price',
        'stock',
    ];
}
