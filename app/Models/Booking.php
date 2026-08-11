<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Booking extends Model
{
    // ni juga :3
        protected $fillable = [
        'booking_code',
        'name',
        'email',
        'phone',
        'treatment_id',
        'branch_id',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
    ];
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
