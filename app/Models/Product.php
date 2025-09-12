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
        "thumbnail_id",
        "name",
        "category",
        "description",
        "created_at",
        "updated_at",
        "visible"
    ];

    protected $hidden = [];

    public function thumbnail(){
        return $this->belongsTo(ProductImage::class, "thumbnail_id");
    }

    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function totalStock(){
        return $this->hasMany(ProductVariant::class)->sum("stock");
    }
}
