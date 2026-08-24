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
    public function isFounder(): bool
    {
        return $this->slug === 'dr-yuly-lie-jaya';
    }
    protected static function booted(): void
    {
        static::deleting(function (Doctor $doctor) {
            if ($doctor->isFounder()) {
                throw new \RuntimeException(
                    'Founder doctor cannot be deleted.'
                );
            }
        });
    }
}
