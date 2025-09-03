<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
