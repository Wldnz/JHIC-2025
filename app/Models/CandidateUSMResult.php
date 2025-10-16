<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateUSMResult extends Model
{
    protected $table = 'candidate_usm_results';

    protected $fillable = [
        'candidate_nisn',
        'user_id',
        'registration_phase_id',
        'selected_major_id',
        'candidate_full_name',
        'candidate_origin_school',
        'registration_phase_name',
        'selected_major_long_name',
        'min_value',
        'average_value',
        'is_passed',
        'signed_at',
        'signed_by',
        'certificate_collection_from_at',
        'certificate_collection_to_at',
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'signed_at' => 'date',
        'certificate_collection_from_at' => 'date',
        'certificate_collection_to_at' => 'date',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_nisn', 'nisn');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrationPhase()
    {
        return $this->belongsTo(RegistrationPhase::class);
    }

    public function selectedMajor()
    {
        return $this->belongsTo(Major::class, 'selected_major_id');
    }
}
