<?php

namespace App\Services;

use App\Models\HomeSection;
use Illuminate\Support\Facades\Cache;

class HomeSectionService
{
    private const CACHE_KEY = 'home_sections';
    private const CACHE_TTL = 3600;

    public function getAll(): array
    {
        return Cache::remember(self::CACHE_KEY . '_' . app()->getLocale(), self::CACHE_TTL, function () {
            $sections = HomeSection::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->keyBy('key');

            $defaults = $this->getDefaults();

            $result = [];
            foreach ($defaults as $key => $default) {
                $section = $sections->get($key);
                $result[$key] = $section ? $this->localize($section->content) : $default;
            }

            return $result;
        });
    }

    public function getRaw(): \Illuminate\Database\Eloquent\Collection
    {
        return HomeSection::orderBy('sort_order')->get();
    }

    public function upsert(string $key, array $content): void
    {
        HomeSection::updateOrCreate(
            ['key' => $key],
            ['content' => $content, 'is_active' => true]
        );
        $this->clearCache();
    }

    public function clearCache(): void
    {
        foreach (['ar', 'en'] as $locale) {
            Cache::forget(self::CACHE_KEY . '_' . $locale);
        }
    }

    private function localize(array $content): array
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $result = [];

        foreach ($content as $k => $v) {
            if (is_array($v) && (isset($v['ar']) || isset($v['en']))) {
                $result[$k] = $v[$locale] ?? $v[$fallback] ?? reset($v);
            } else {
                $result[$k] = $v;
            }
        }

        return $result;
    }

    public function getDefaults(): array
    {
        return [
            'hero' => [
                'eyebrow'  => __('landing.hero.eyebrow'),
                'title1'   => __('landing.hero.title1'),
                'title2'   => __('landing.hero.title2'),
                'subtitle' => __('landing.hero.subtitle'),
                'cta1'     => __('landing.hero.cta1'),
                'cta1_url' => '#contact',
                'cta2'     => __('landing.hero.cta2'),
                'cta2_url' => '#projects',
            ],
            'stats' => [
                'projects_count' => '250+',
                'projects_label' => __('landing.stats.projects'),
                'years_count'    => '15+',
                'years_label'    => __('landing.stats.years'),
                'countries_count' => '12',
                'countries_label' => __('landing.stats.countries'),
                'clients_count'  => '180+',
                'clients_label'  => __('landing.stats.clients'),
            ],
            'services_section' => [
                'eyebrow'  => __('landing.services.eyebrow'),
                'title'    => __('landing.services.title'),
                'subtitle' => __('landing.services.subtitle'),
            ],
            'process_section' => [
                'eyebrow' => __('landing.process.eyebrow'),
                'title'   => __('landing.process.title'),
            ],
            'projects_section' => [
                'eyebrow'  => __('landing.projects.eyebrow'),
                'title'    => __('landing.projects.title'),
                'subtitle' => __('landing.projects.subtitle'),
            ],
            'testimonials_section' => [
                'eyebrow' => __('landing.test.eyebrow'),
                'title'   => __('landing.test.title'),
            ],
            'cta' => [
                'title'    => __('landing.cta.title'),
                'subtitle' => __('landing.cta.subtitle'),
                'button'   => __('landing.cta.button'),
            ],
        ];
    }
}
