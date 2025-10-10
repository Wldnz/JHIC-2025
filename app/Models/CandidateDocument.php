<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateDocument extends Model
{
    protected $table = 'candidate_documents';

    protected $fillable = [
        'candidate_nisn',
        'name',
        'file_url',
    ];

    /**
     * Get the candidate that owns the candidate document.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_nisn', 'nisn');
    }
}
