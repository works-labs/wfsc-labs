<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    // iyapp ini juga 
        protected $fillable = [
        'name',
        'description',
        'image',
        'sort_order',
        'is_active',
    ];
}
