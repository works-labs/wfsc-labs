<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoImage extends Model
{
    protected $fillable = ['promo_id', 'path', 'sort_order'];

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}
