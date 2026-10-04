<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Render sitemap XML with all public static URLs.
     *
     * Only static public routes are included here.
     * Dynamic slug-based pages (doctors, treatments, news, etc.)
     * are omitted to avoid DB dependency and fictitious URLs.
     */
    public function index(): Response
    {
        $baseUrl = 'https://wfscclinic.com';

        $urls = [
            ['loc' => $baseUrl . '/'],
            ['loc' => $baseUrl . '/treatments'],
            ['loc' => $baseUrl . '/news'],
            ['loc' => $baseUrl . '/promos'],
            ['loc' => $baseUrl . '/skincare'],
            ['loc' => $baseUrl . '/before-after'],
            ['loc' => $baseUrl . '/contact-us'],
        ];

        $content = view('sitemap', ['urls' => $urls])->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
