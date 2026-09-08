<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SkincareProduct extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'shopee_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            SkincareCategory::class,
            'skincare_category_product',
            'skincare_product_id',
            'skincare_category_id'
        );
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(
            SkincareAttribute::class,
            'skincare_attribute_product',
            'skincare_product_id',
            'skincare_attribute_id'
        );
    }
}