<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Promo;

class PublicPromoController extends Controller
{
    public function index()
    {
        $banners = Banner::query()
            ->where('placement', 'promos')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('mode');

        $desktopBanner = $banners->get('desktop');
        $mobileBanner = $banners->get('mobile');

        $promos = Promo::query()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.promos.index', [
            'desktopBanner' => $desktopBanner,
            'mobileBanner' => $mobileBanner,
            'promos' => $promos,
        ]);
    }
}
