<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SiteSetting;

class Promo extends Model
{
    protected $fillable = [
        'treatment_product_id',
        'title',
        'slug',
        'description',
        'image',
        'cta_text',
        'cta_type',
        'cta_target',
        'start_date',
        'end_date',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function treatmentProduct(): BelongsTo
    {
        return $this->belongsTo(TreatmentProduct::class);
    }

    public function getCtaUrlAttribute(): string
    {
        return match ($this->cta_type) {
            'internal' => match ($this->cta_target) {
                'home' => route('home'),
                'treatments' => route('treatments.index'),
                'doctors' => route('doctor.show', ['doctor' => $this->cta_target]), // Menyesuaikan route doctors jika ada index, atau fallback ke home/doctors
                'news' => route('news.show', ['news' => $this->cta_target]),
                default => '#',
            },
            'treatment' => $this->cta_target ? route('treatment.show', ['treatment' => $this->cta_target]) : '#', // Fixed: treatment.show
            'doctor' => $this->cta_target ? route('doctor.show', ['doctor' => $this->cta_target]) : '#',       // Fixed: doctor.show
            'news' => $this->cta_target ? route('news.show', ['news' => $this->cta_target]) : '#',
            'whatsapp' => $this->getWhatsappUrl(),
            'external' => $this->cta_target ?? '#',
            default => '#',
        };
    }

    private function getWhatsappUrl(): string
    {
        $number = SiteSetting::where('key', 'whatsapp_number')->value('value');
        $cleanNumber = preg_replace('/[^0-9]/', '', $number ?? '');

        return $cleanNumber ? "https://wa.me/{$cleanNumber}" : '#';
    }
}