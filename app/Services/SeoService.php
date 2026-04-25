<?php

namespace App\Services;

use App\Models\SeoMeta;
use App\Models\SeoRedirect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SeoService
{
    /**
     * Update or create SEO metadata for a model
     */
    public function updateSeo(Model $model, array $data): SeoMeta
    {
        // Handle OG Image
        if (isset($data['og_image']) && $data['og_image'] instanceof \Illuminate\Http\UploadedFile) {
            $oldSeo = $model->seoMeta;
            if ($oldSeo && $oldSeo->og_image) {
                Storage::disk('public')->delete($oldSeo->og_image);
            }
            $data['og_image'] = $data['og_image']->store('seo/og-images', 'public');
        }

        return $model->seoMeta()->updateOrCreate(
            ['seoable_id' => $model->id, 'seoable_type' => get_class($model)],
            $data
        );
    }

    /**
     * Get SEO metadata for a model
     */
    public function getSeo(Model $model): ?SeoMeta
    {
        return $model->seoMeta;
    }

    /**
     * Resolve SEO for any entity, with fallbacks
     */
    public function resolveSeo(Model $model): array
    {
        $seo = $this->getSeo($model);
        $locale = app()->getLocale();

        return [
            'title' => $seo ? ($seo->getTranslation('title') ?: $model->getTranslation('title')) : $model->getTranslation('title'),
            'description' => $seo ? ($seo->getTranslation('description') ?: $model->getTranslation('short_description')) : $model->getTranslation('short_description'),
            'keywords' => $seo ? $seo->getTranslation('keywords') : '',
            'og_title' => $seo ? $seo->getTranslation('og_title') : '',
            'og_description' => $seo ? $seo->getTranslation('og_description') : '',
            'og_image' => $seo ? asset('storage/' . $seo->og_image) : '',
            'canonical' => $seo ? $seo->canonical_url : url()->current(),
            'robots' => $seo ? $seo->robots : 'index,follow',
        ];
    }

    /**
     * Manage Redirects
     */
    public function createRedirect(string $old, string $new, int $status = 301): SeoRedirect
    {
        return SeoRedirect::create([
            'old_url' => $old,
            'new_url' => $new,
            'status_code' => $status
        ]);
    }

    public function checkRedirect(string $url): ?SeoRedirect
    {
        return SeoRedirect::where('old_url', $url)->where('is_active', true)->first();
    }
}
