<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryType extends Model
{
    protected $table = 'gallery_types';

    protected $fillable = [
        'name',
    ];

    /**
     * Get the galleries for the gallery type.
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}
