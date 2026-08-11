<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    // kalo inii dikit ajah >//<
        protected $fillable = [
        'title',
        'subtitle',
        'background_image',
        'cta_text',
        'cta_url',
        'sort_order',
        'is_active',
    ];
}
