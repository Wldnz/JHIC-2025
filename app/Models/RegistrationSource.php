<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationSource extends Model
{
    protected $table = 'registration_sources';

    protected $fillable = [
        'name',
    ];

    /**
     * Get the candidates for the registration source.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }
}
