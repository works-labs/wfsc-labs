<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    protected $fillable = [
        'author_id',
        'category_id',
        'baca_juga_id',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function relatedNews(): BelongsToMany
    {
        return $this->belongsToMany(
            News::class,
            'news_related',
            'news_id',
            'related_news_id'
        );
    }

    public function relatedToNews(): BelongsToMany
    {
        return $this->belongsToMany(
            News::class,
            'news_related',
            'related_news_id',
            'news_id'
        );
    }

    public function bacaJuga(): BelongsTo
    {
        return $this->belongsTo(
            News::class,
            'baca_juga_id'
        );
    }
}