<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Keyword extends Model
{
    protected $fillable = ['name'];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'articles_keywords', 'keyword_id', 'article_id');
    }
}
