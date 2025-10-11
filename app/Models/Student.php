<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'user_id',
        'name',
        'class',
        'major_id',
        'major_long_name',
        'major_short_name',
        'gender',
        'birthdate',
    ];

    /**
     * Get the user that owns the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the major that the student belongs to.
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    /**
     * Get the portfolios for the student.
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'student_nis', 'nis');
    }

    /**
     * Get the achievements for the student.
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'student_nis', 'nis');
    }
}
