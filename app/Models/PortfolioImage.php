<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioImage extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioImageFactory> */
    use HasFactory;

    protected $table = 'portfolio_images';

    protected $fillable = [
        'portfolio_id',
        'url',
        'is_thumbnail',
    ];

    protected $casts = [
        'is_thumbnail' => 'boolean',
    ];

    /**
     * Get the portfolio that owns the portfolio image.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
