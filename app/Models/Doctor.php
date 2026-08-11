<?php

namespace App\Models;
use App\Models\DoctorHomeSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Doctor extends Model
{
    // add models :)
     protected $fillable = [
        'name',
        'slug',
        'title',
        'photo',
        'short_bio',
        'bio',
        'specialization',
        'education',
        'certifications',
        'experience',
        'is_active',
    ];

    public function homeSections(): HasMany
    {
        return $this->hasMany(DoctorHomeSection::class);
    }
}
