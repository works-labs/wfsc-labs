<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class DoctorHomeSection extends Model
{
    // add models :)
    protected $fillable = [
        'doctor_id',
        'section',
        'sort_order',
        'is_active',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function isFounder(): bool
    {
        return $this->doctor?->isFounder() ?? false;
    }
}
