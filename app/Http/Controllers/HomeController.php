<?php

namespace App\Http\Controllers;

use App\Models\DoctorHomeSection;
use App\Models\HeroBanner;
use App\Models\SiteStatistic;
use App\Models\TreatmentBeforeAfter;
use App\Models\TreatmentCategory;
use Illuminate\View\View;
use App\Models\WhyChooseItem;
use App\Models\Facility;
use App\Models\Promo;
use App\Models\News;
use App\Models\Branch;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroBanners = HeroBanner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $heroDoctors = DoctorHomeSection::query()
            ->where('section', 'hero')
            ->where('is_active', true)
            ->whereHas('doctor', function ($query) {
                $query->where('is_active', true);
            })
            ->with('doctor')
            ->orderBy('sort_order')
            ->get();

        $statistics = SiteStatistic::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $treatmentCategories = TreatmentCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $treatmentBeforeAfters = TreatmentBeforeAfter::query()
            ->with('treatment')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $whyChooseItems = WhyChooseItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $facilities = Facility::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();


        $homeDoctors = DoctorHomeSection::query()
            ->where('section', 'doctors')
            ->where('is_active', true)
            ->whereHas('doctor', function ($query) {
                $query->where('is_active', true);
            })
            ->with('doctor')
            ->orderBy('sort_order')
            ->get();

        $promos = Promo::query()
            ->where('is_active', true)
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
    
        $branches = Branch::query()
            ->where('is_active', true)
            ->get();

        $settings = SiteSetting::query()
            ->whereIn('key', [
                'whatsapp_number',
                'site_phone',
                'site_email',
                'operating_hours',
                'instagram_url',
                'tiktok_url',
                'threads_url',
            ])
            ->pluck('value', 'key');
            
        return view('public.home', [
            'heroBanners' => $heroBanners,
            'heroDoctors' => $heroDoctors,
            'homeDoctors' => $homeDoctors,
            'statistics' => $statistics,
            'treatmentCategories' => $treatmentCategories,
            'treatmentBeforeAfters' => $treatmentBeforeAfters,
            'whyChooseItems' => $whyChooseItems,
            'facilities' => $facilities,
            'promos' => $promos,
            'news' => $news,
            'branches' => $branches,
            'settings' => $settings,
        ]);
    }
}