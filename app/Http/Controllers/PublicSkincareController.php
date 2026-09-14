<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        $products = SkincareProduct::query()
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
            ->orderBy('name')
            ->get();

        $activeCategory = $request->category;

        return view('public.skincare.index', compact(
            'categories',
            'products',
            'activeCategory'
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

        return view('public.skincare.show', compact('product'));
    }
}