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
        "description",
        "created_at",
        "updated_at",
        "visible"
    ];

    protected $hidden = [];

    public function images(){
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }

    public function thumbnail(){
        return $this->images->where("thumbnail", true)->first();
    }

    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function totalStock(){
        return $this->variants->query()->sum("stock");
    }
}
