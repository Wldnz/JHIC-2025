<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'nis';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nis',
        'no_telp',
        'gender',
        'address',
        'birthdate',
        'class',
        'major_id',
        'major_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nis', 'nis');
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
