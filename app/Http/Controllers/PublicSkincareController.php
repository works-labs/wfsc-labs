<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\SiteSetting;
use App\Models\SkincareCategory;
use App\Models\SkincareProduct;
use Illuminate\Http\Request;

class PublicSkincareController extends Controller
{
    public function index(Request $request)
    {
        $categories = SkincareCategory::query()
            ->where('is_active', true)
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $productsQuery = SkincareProduct::query()
            ->where('is_active', true)
            ->with([
                'categories' => function ($query) {
                    $query->where('is_active', true);
                },
                'attributes' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->when(
                $request->filled('category'),
                function ($query) use ($request) {
                    $query->whereHas('categories', function ($categoryQuery) use ($request) {
                        $categoryQuery
                            ->where('is_active', true)
                            ->where('slug', $request->category);
                    });
                }
            )
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($request->filled('category')) {
            $activeCategory = SkincareCategory::query()
                ->where('slug', $request->category)
                ->where('is_active', true)
                ->first();

            if ($activeCategory) {
                $productsQuery
                    ->join('skincare_category_product as category_product_order', function ($join) use ($activeCategory) {
                        $join->on('category_product_order.skincare_product_id', '=', 'skincare_products.id')
                            ->where('category_product_order.skincare_category_id', $activeCategory->id);
                    })
                    ->select('skincare_products.*')
                    ->reorder()
                    ->orderBy('category_product_order.sort_order')
                    ->orderBy('skincare_products.sort_order')
                    ->orderBy('skincare_products.name');
            }
        }

        $products = $productsQuery->get();

        $activeCategory = $request->category;

        $banners = Banner::query()
            ->where('placement', 'skincare')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('mode');

        $desktopBanner = $banners->get('desktop');
        $mobileBanner = $banners->get('mobile');

        return view('public.skincare.index', compact(
            'categories',
            'products',
            'activeCategory',
            'desktopBanner',
            'mobileBanner'
        ));
    }

    public function show(string $slug)
    {
        $product = SkincareProduct::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'categories' => function ($query) {
                    $query->where('is_active', true);
                },
                'attributes' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->firstOrFail();

        $whatsappNumber = SiteSetting::query()
            ->where('key', 'whatsapp_number')
            ->value('value');

        $whatsappUrl = null;
        if ($whatsappNumber) {
            $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
            $whatsappUrl = $cleanNumber ? "https://wa.me/{$cleanNumber}" : null;
        }

        return view('public.skincare.show', compact('product', 'whatsappUrl'));
    }
}
