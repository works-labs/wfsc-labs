<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Branch;

class PublicContactUsController extends Controller
{
    public function index()
    {
        $banner = Banner::query()
            ->where('placement', 'contact-us')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();

        $branches = Branch::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('public.contact-us.index', compact(
            'banner',
            'branches'
        ));
    }
}