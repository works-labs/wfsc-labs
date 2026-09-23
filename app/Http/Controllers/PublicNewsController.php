<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    public function index(Request $request)
    {
        $categories = NewsCategory::query()
            ->where('is_active', true)
            ->withCount([
                'news' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->orderBy('name')
            ->get();

        $featuredNews = News::query()
            ->where('is_active', true)
            ->with([
                'category',
                'author',
            ])
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        $news = News::query()
            ->where('is_active', true)
            ->with([
                'category',
                'author',
            ])
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('is_active', true)
                        ->where('slug', $request->category);
                });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        $activeCategory = $request->category;

        return view('public.news.index', [
            'categories' => $categories,
            'featuredNews' => $featuredNews,
            'news' => $news,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(News $news)
    {
        abort_unless($news->is_active, 404);

        $news->load([
            'author',
            'category',

            'bacaJuga' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->with('category');
            },

            'relatedNews' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->with('category')
                    ->orderByDesc('published_at')
                    ->orderByDesc('created_at');
            },
        ]);

        $bacaJuga = $news->bacaJuga;

        $recommendedNews = $news->relatedNews
            ->take(3)
            ->values();

        return view('public.news.show', [
            'news' => $news,
            'bacaJuga' => $bacaJuga,
            'recommendedNews' => $recommendedNews,
        ]);
    }
}