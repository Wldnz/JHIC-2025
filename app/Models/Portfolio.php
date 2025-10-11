<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioFactory> */
    use HasFactory;

    protected $fillable = [
        'student_nis',
        'student_name',
        'student_class',
        'student_major_id',
        'student_major_name',
        'title',
        'description',
        'link_type',
        'supporting_link',
    ];

    /**
     * Get the student that owns the portfolio.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_nis', 'nis');
    }

    /**
     * Get the major that the student belongs to.
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'student_major_id');
    }

    /**
     * Get the portfolio images for the portfolio.
     */
    public function portfolioImages(): HasMany
    {
        return $this->hasMany(PortfolioImage::class);
    }
}
