<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationPhase extends Model
{
    protected $table = 'registration_phases';

    protected $fillable = [
        'name',
        'quota',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Get the candidates for the registration phase.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'selected_phase_id');
    }
}
