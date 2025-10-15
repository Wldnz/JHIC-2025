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
        'user_id',
        'name',
        'mime_types',
        'file_url',
        'is_valid',
    ];

    /**
     * Get the candidate that owns the candidate document.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the user that owns the candidate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
