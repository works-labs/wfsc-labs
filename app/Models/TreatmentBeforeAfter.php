<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TreatmentBeforeAfter extends Model
{
    // add modelss ini juga :) >//<
    protected $fillable = [
        'treatment_id',
        'before_image',
        'after_image',
        'caption',
        'sort_order',
        'is_active',
    ];
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
}
