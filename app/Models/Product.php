<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $primaryKey = "id";
    protected $keyType = "string";


    protected $fillable = [
        "id",
        "name",
        "category",
        "created_at",
        "updated_at",
        "visible"
    ];

    protected $hidden = [];
}
