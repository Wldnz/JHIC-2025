<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory;

    protected $table = 'product_image';
    
    protected $fillable = [
        'id',
        'product_id',
        'url',
        'visible'
    ];

    protected $hidden = [];
}
