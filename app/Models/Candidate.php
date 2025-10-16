<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registrationPhase(): HasOneThrough
    {
        return $this->hasOneThrough(RegistrationPhase::class, CandidatePhase::class, 'candidate_nisn', 'id', 'nisn', 'selected_phase_id');
    }

    public function registrationSource(): HasOneThrough
    {
        return $this->hasOneThrough(RegistrationSource::class, CandidatePhase::class, 'candidate_nisn', 'id', 'nisn', 'registration_source_id');
    }

    public function candidateMajors(): HasMany
    {
        return $this->hasMany(CandidateMajor::class, 'candidate_nisn', 'nisn');
    }

    public function candidateGuardian(): HasOne
    {
        return $this->hasOne(CandidateGuardian::class, 'candidate_nisn', 'nisn');
    }

    public function candidateDocuments(): HasMany
    {
        return $this->hasMany(CandidateDocument::class, 'candidate_nisn', 'nisn');
    }

    public function candidatePhase(): HasOne
    {
        return $this->hasOne(CandidatePhase::class, 'candidate_nisn', 'nisn');
    }

    public function candidateUSMResult(): HasOne
    {
        return $this->hasOne(CandidateUSMResult::class, 'candidate_nisn', 'nisn');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'candidate_nisn', 'nisn');
    }
}
