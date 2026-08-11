<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TreatmentVideo extends Model
{
    protected $fillable = [
        'treatment_id',
        'title',
        'video_path',
        'description',
        'sort_order',
        'is_active',
    ];

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
}