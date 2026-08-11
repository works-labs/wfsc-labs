<?php

namespace App\Http\Controllers;

use App\Models\DoctorHomeSection;
use App\Models\HeroBanner;
use App\Models\SiteStatistic;
use App\Models\TreatmentBeforeAfter;
use App\Models\TreatmentCategory;
use Illuminate\View\View;

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

        return view('public.home', [
            'heroBanners' => $heroBanners,
            'heroDoctors' => $heroDoctors,
            'statistics' => $statistics,
            'treatmentCategories' => $treatmentCategories,
            'treatmentBeforeAfters' => $treatmentBeforeAfters,
        ]);
    }
}