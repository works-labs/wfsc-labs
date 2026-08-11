<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TreatmentBeforeAfter extends Model
{
    // add modelss ini juga :) >//<
    protected $fillable = [
        'treatment_id',
        'before_media',
        'before_media_type',
        'after_media',
        'after_media_type',
        'caption',
        'sort_order',
        'is_active',
    ];
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
}
