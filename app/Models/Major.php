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

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'student_major_id');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'student_major_id');
    }

    public function candidateMajors(): HasMany
    {
        return $this->hasMany(CandidateMajor::class);
    }

    public function alumni(): HasMany
    {
        return $this->hasMany(MajorAlumnus::class);
    }
}
