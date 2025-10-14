<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidate extends Model
{
    /** @use HasFactory<\Database\Factories\CandidateFactory> */
    use HasFactory;

    protected $table = 'candidates';
    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nisn',
        'user_id',
        'full_name',
        'short_name',
        'birthdate',
        'birthplace',
        'gender',
        'citizenship',
        'religion',
        'address',
        'status_family',
        'order_family',
        'sum_siblings',
        'sum_half_siblings',
        'sum_adopted_siblings',
        'phone',
        'origin_school',
        'origin_school_address',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    /**
     * Get the user that owns the candidate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the registration phase that the candidate belongs to.
     */
    public function registrationPhase(): BelongsTo
    {
        return $this->belongsTo(CandidatePhase::class, 'candidate_nisn', 'nisn', 'selected_phase_id');
    }

    /**
     * Get the registration source that the candidate belongs to.
     */
    public function registrationSource(): BelongsTo
    {
        return $this->belongsTo(CandidatePhase::class, 'candidate_nisn', 'nisn', 'registration_source_id');
    }

    /**
     * Get the candidate majors for the candidate.
     */
    public function candidateMajors(): HasMany
    {
        return $this->hasMany(CandidateMajor::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the candidate guardian for the candidate.
     */
    public function candidateGuardian(): HasOne
    {
        return $this->hasOne(CandidateGuardian::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the candidate documents for the candidate.
     */
    public function candidateDocuments(): HasMany
    {
        return $this->hasMany(CandidateDocument::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the candidate guardian for the candidate.
     */
    public function candidatePhase(): HasOne
    {
        return $this->hasOne(CandidatePhase::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the transactions for the candidate.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'candidate_nisn', 'nisn');
    }
}
