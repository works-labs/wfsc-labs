<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Treatment;

class PublicBeforeAfterController extends Controller
{
    public function index()
    {
        $treatments = Treatment::query()
            ->where('is_active', true)
            ->whereHas('beforeAfters', function ($query) {
                $query->where('is_active', true);
            })
            ->with([
                'beforeAfters' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('sort_order');
                },
            ])
            ->orderBy('name')
            ->get();

        $banners = Banner::query()
            ->where('placement', 'before-after')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('mode');

        return view('public.before-after.index', [
            'treatments' => $treatments,
            'desktopBanner' => $banners->get('desktop'),
            'mobileBanner' => $banners->get('mobile'),
        ]);
    }
}
