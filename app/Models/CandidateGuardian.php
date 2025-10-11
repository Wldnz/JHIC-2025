<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateGuardian extends Model
{
    protected $table = 'candidate_guardians';

    protected $fillable = [
        'candidate_nisn',
        'guardian_type',
        'full_name',
        'birthplace',
        'birthdate',
        'citizenship',
        'religion',
        'education',
        'job',
        'monthly_income',
        'home_address',
        'rt_rw',
        'sub_district',
        'district',
        'city',
        'postal_code',
        'home_phone_number',
        'office_phone_number',
        'phone_number',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    /**
     * Get the candidate that owns the candidate guardian.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'candidate_nisn', 'nisn');
    }
}
