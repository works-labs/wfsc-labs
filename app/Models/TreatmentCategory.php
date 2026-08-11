<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class TreatmentCategory extends Model
{
    // add models :)
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'sort_order',
        'is_active',
    ];
    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class, 'category_id');
    }
}
