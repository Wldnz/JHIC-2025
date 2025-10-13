<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationDocument extends Model
{
    protected $table = 'registration_documents';

    protected $fillable = [
        'name',
        'mime_types',
        'is_required',
        'file_download_url',
    ];
}
