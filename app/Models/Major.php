<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $table = 'majors';

    protected $fillable = [
        'long_name',
        'short_name',
    ];

    /**
     * Get the students for the major.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the portfolios for the major.
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'student_major_id');
    }

    /**
     * Get the achievements for the major.
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'student_major_id');
    }

    /**
     * Get the candidate majors for the major.
     */
    public function candidateMajors(): HasMany
    {
        return $this->hasMany(CandidateMajor::class);
    }
}
