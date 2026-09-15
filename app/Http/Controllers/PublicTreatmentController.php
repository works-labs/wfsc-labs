<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\View\View;

class PublicTreatmentController extends Controller
{
    public function index(): View
    {
        $categories = TreatmentCategory::query()
            ->where('is_active', true)
            ->with([
                'treatments' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('id');
                },
            ])
            ->orderBy('sort_order')
            ->get();

        $news = News::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        $banner = \App\Models\Banner::query()
            ->where('placement', 'treatments')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();

        return view('public.treatments.index', [
            'banner' => $banner,
            'categories' => $categories,
            'news' => $news,
        ]);
    }

    public function show(Treatment $treatment): View
    {
        abort_unless($treatment->is_active, 404);

        $treatment->load([
            'category',

            'procedureVideos' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->orderBy('sort_order');
            },

            'products' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->orderBy('sort_order');
            },

            'beforeAfters' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->orderBy('sort_order');
            },
            'relatedTreatments' => function ($query) {
                $query->where('is_active', true)
                    ->with('category')
                    ->orderBy('name');
            },
        ]);

        $settings = \App\Models\SiteSetting::query()
            ->whereIn('key', ['whatsapp_number'])
            ->pluck('value', 'key');

        $whatsappUrl = null;
        if (!empty($settings['whatsapp_number'])) {
            $cleanNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number']);
            $whatsappUrl = $cleanNumber ? "https://wa.me/{$cleanNumber}" : null;
        }

        return view('public.treatments.show', [
            'treatment' => $treatment,
            'whatsappUrl' => $whatsappUrl,
        ]);
    }
}