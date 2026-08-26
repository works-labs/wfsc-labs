<?php

namespace App\View\Composers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class PublicViewComposer
{
    public function compose(View $view): void
    {
        $whatsappUrl = null;

        $whatsappNumber = SiteSetting::query()
            ->where('key', 'whatsapp_number')
            ->value('value');

        if (!empty($whatsappNumber)) {
            $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);

            if ($cleanNumber) {
                $whatsappUrl = "https://wa.me/{$cleanNumber}";
            }
        }

        $view->with('whatsappUrl', $whatsappUrl);
    }
}