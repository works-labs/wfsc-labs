<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Promo;

class PublicPromoController extends Controller
{
    public function index()
    {
        $banner = Banner::query()
            ->where('placement', 'promos')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();

        $promos = Promo::query()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.promos.index', [
            'banner' => $banner,
            'promos' => $promos,
        ]);
    }
}