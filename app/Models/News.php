<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class News extends Model
{
    // add modyelllsss yippiiii >_<
        protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'published_at',
        'is_featured',
        'is_active',
    ];
     protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
