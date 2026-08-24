<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class HeroBanner extends Model
{
    // kalo inii dikit ajah >//<
        protected $fillable = [
        'title',
        'subtitle',
        'background_image',
        'cta_text',
        'cta_type',
        'cta_target',
        'sort_order',
        'is_active',
    ];

    public function getCtaUrl(): ?string
    {
        return match ($this->cta_type) {
            'internal' => match ($this->cta_target) {
                'home' => route('home'),
                'treatments' => route('treatments.index'),
                'doctors' => url('/#doctors'),
                'news' => url('/#news'),
                default => null,
            },

            'treatment' => $this->cta_target
                ? route('treatment.show', $this->cta_target)
                : null,

            'doctor' => $this->cta_target
                ? route('doctor.show', $this->cta_target)
                : null,

            'news' => $this->cta_target
                ? route('news.show', $this->cta_target)
                : null,

            'whatsapp' => $this->getWhatsappUrl(),

            'external' => $this->cta_target ?: null,

            default => null,
        };
    }

    protected function getWhatsappUrl(): ?string
    {
        $number = \App\Models\SiteSetting::query()
            ->where('key', 'whatsapp_number')
            ->value('value');

        if (! $number) {
            return null;
        }

        $number = preg_replace('/[^0-9]/', '', $number);

        return 'https://wa.me/' . $number;
    }
}
