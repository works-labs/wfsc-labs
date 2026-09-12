<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    public function index()
    {
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
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('public.news.index', [
            'featuredNews' => $featuredNews,
            'news' => $news,
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