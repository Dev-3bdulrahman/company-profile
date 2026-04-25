<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(\App\Services\Internal\SitemapService $service): Response
    {
        $urls = $service->generateSitemapData();

        $content = view('sitemap', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
