<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'selected_phase_id',
        'selected_phase_name',
        'registration_source_id',
        'registration_source',
        'origin_school',
        'origin_school_address',
        'enrolling_reason',
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
        return $this->belongsTo(RegistrationPhase::class, 'selected_phase_id');
    }

    /**
     * Get the registration source that the candidate belongs to.
     */
    public function registrationSource(): BelongsTo
    {
        return $this->belongsTo(RegistrationSource::class, 'registration_source_id');
    }

    /**
     * Get the candidate majors for the candidate.
     */
    public function candidateMajors(): HasMany
    {
        return $this->hasMany(CandidateMajor::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the candidate guardians for the candidate.
     */
    public function candidateGuardians(): HasMany
    {
        return $this->hasMany(CandidateGuardian::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the candidate documents for the candidate.
     */
    public function candidateDocuments(): HasMany
    {
        return $this->hasMany(CandidateDocument::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the transactions for the candidate.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'candidate_nisn', 'nisn');
    }
}
