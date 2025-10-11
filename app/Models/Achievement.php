<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    /** @use HasFactory<\Database\Factories\AchievementFactory> */
    use HasFactory;

    protected $table = 'achievements';

    protected $fillable = [
        'student_nis',
        'student_name',
        'student_class',
        'student_major_id',
        'student_major_name',
        'competition_position',
        'competition_name',
        'competition_level',
        'won_at',
        'thumbnail_url',
    ];

    protected $casts = [
        'won_at' => 'datetime',
    ];

    /**
     * Get the student that owns the achievement.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_nis', 'nis');
    }

    /**
     * Get the major that the student belongs to.
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'student_major_id');
    }
}
