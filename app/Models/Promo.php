<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    // inii samaaa
        protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'cta_text',
        'cta_url',
        'start_date',
        'end_date',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'is_active' => 'boolean',
];
}
