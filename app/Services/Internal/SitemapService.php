<?php

namespace App\Services\Internal;

use App\Models\PortfolioItem;
use App\Models\SiteSetting;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;

class SitemapService extends BaseInternalService
{
    public function generateSitemapData(): array
    {
        $baseUrl = request()?->getSchemeAndHttpHost() ?: rtrim(config('app.url'), '/');
        $baseUrl = rtrim($baseUrl, '/');
        $locales = ['ar', 'en'];

        $siteLastMod = SiteSetting::latest('updated_at')->value('updated_at');
        $siteLastMod = $siteLastMod ? $siteLastMod->toAtomString() : now()->toAtomString();

        // 1. Core Pages
        $urls = [
            $this->formatUrl($baseUrl . '/', $siteLastMod, 'weekly', '1.0'),
            $this->formatUrl($baseUrl . '/services', $siteLastMod, 'weekly', '0.9'),
            $this->formatUrl($baseUrl . '/projects', $siteLastMod, 'weekly', '0.9'),
            $this->formatUrl($baseUrl . '/blog', $siteLastMod, 'weekly', '0.9'),
            $this->formatUrl($baseUrl . '/contact', $siteLastMod, 'monthly', '0.7'),
            $this->formatUrl($baseUrl . '/privacy-policy', $siteLastMod, 'monthly', '0.5'),
            $this->formatUrl($baseUrl . '/terms-of-service', $siteLastMod, 'monthly', '0.5'),
        ];

        // 2. Dynamic Pages
        $pages = Page::where('is_active', true)->orderBy('sort_order')->get();
        foreach ($pages as $page) {
            $urls[] = $this->formatUrl($baseUrl . '/' . $page->slug, $page->updated_at->toAtomString(), 'monthly', '0.8');
        }

        // 3. Blog Posts
        $posts = Post::published()->orderBy('published_at', 'desc')->get();
        foreach ($posts as $post) {
            $urls[] = $this->formatUrl($baseUrl . '/blog/' . $post->slug, $post->published_at->toAtomString(), 'monthly', '0.8');
        }

        // 4. Portfolio Items
        $portfolio = PortfolioItem::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        foreach ($portfolio as $item) {
            $urls[] = $this->formatUrl($baseUrl . '/projects/' . $item->slug, $item->updated_at->toAtomString(), 'monthly', '0.8');
        }

        // 5. Services
        $services = Service::active()->whereNotNull('slug')->orderBy('sort_order')->get();
        foreach ($services as $service) {
            $urls[] = $this->formatUrl($baseUrl . '/services/' . $service->slug, $service->updated_at->toAtomString(), 'monthly', '0.8');
        }

        return $urls;
    }

    private function formatUrl(string $url, string $lastmod, string $freq, string $priority): array
    {
        $locales = ['ar', 'en'];
        return [
            'loc'        => $url,
            'lastmod'    => $lastmod,
            'changefreq' => $freq,
            'priority'   => $priority,
            'alternates' => array_merge(
                array_combine($locales, array_map(fn($l) => $url . (str_contains($url, '?') ? '&' : '?') . 'lang=' . $l, $locales)),
                ['x-default' => $url]
            ),
        ];
    }
}
