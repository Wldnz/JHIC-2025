<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'name',
        'url',
        'description',
        'media_type',
        'gallery_type_id',
        'gallery_type_name',
    ];

    /**
     * Get the gallery type that owns the gallery.
     */
    public function galleryType(): BelongsTo
    {
        return $this->belongsTo(GalleryType::class);
    }
}
