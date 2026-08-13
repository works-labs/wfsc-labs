<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    public function show(News $news): View
    {
        abort_unless(
            $news->is_active &&
            $news->published_at &&
            $news->published_at->isPast(),
            404
        );

        return view('public.news.show', [
            'news' => $news,
        ]);
    }
}