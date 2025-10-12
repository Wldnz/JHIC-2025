<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidatePhase extends Model
{
    protected $table = 'candidate_phases';

    protected $fillable = [
        'candidate_nisn',
        'selected_phase_id',
        'selected_phase_name',
        'registration_source_id',
        'registration_source',
        'enrolling_reason',
    ];

    /**
     * Get the candidate that owns the candidate guardian.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_nisn', 'nisn');
    }

    /**
     * Get the registration phase associated with the candidate phase.
     */
    public function selectedPhase(): BelongsTo
    {
        return $this->belongsTo(RegistrationPhase::class, 'selected_phase_id');
    }

    /**
     * Get the registration source associated with the candidate phase.
     */
    public function registrationSource(): BelongsTo
    {
        return $this->belongsTo(RegistrationSource::class, 'registration_source_id');
    }
}
