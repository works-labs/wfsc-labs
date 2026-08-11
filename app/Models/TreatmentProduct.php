<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TreatmentProduct extends Model
{
    // add modyels iyaawww >_< 
    protected $fillable = [
        'treatment_id',
        'name',
        'description',
        'image',
        'sort_order',
        'is_active',
    ];
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
}
