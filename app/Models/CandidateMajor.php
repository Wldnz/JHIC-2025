<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateMajor extends Model
{
    protected $table = 'candidate_majors';

    protected $fillable = [
        'candidate_nisn',
        'major_id',
        'major_long_name',
        'major_short_name',
    ];

    /**
     * Get the candidate that owns the candidate major.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the major that owns the candidate major.
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }
}
