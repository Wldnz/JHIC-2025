<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
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
}
