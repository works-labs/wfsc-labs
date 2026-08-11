<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseItem extends Model
{
    // nahhhhh iniii sama si wkwk
        protected $fillable = [
        'title',
        'description',
        'icon',
        'sort_order',
        'is_active',
    ];
}
