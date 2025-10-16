<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MajorAlumnus extends Model
{
    protected $table = 'major_alumni';

    protected $fillable = [
        'major_id',
        'image_url',
        'name',
        'message',
        'major_long_name',
        'major_short_name',
        'current_company',
        'current_company_position',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
