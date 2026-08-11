<?php

namespace App\Models;
use App\Models\TreatmentCategory;
use App\Models\TreatmentProduct;
use App\Models\TreatmentBeforeAfter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Treatment extends Model
{
    // add models dulu bjir :)
     protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'cover_image',
        'is_featured',
        'is_active',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(TreatmentCategory::class, 'category_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(TreatmentProduct::class);
    }

    public function beforeAfters(): HasMany
    {
        return $this->hasMany(TreatmentBeforeAfter::class);
    }
}
