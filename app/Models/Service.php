<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'full_description',
        'hero_image',
        'gallery',
        'features',
        'cta_title',
        'cta_text',
        'cta_url',
        'faqs',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'short_description' => 'array',
        'full_description' => 'array',
        'gallery' => 'array',
        'features' => 'array',
        'cta_title' => 'array',
        'cta_text' => 'array',
        'faqs' => 'array',
        'seo_title' => 'array',
        'seo_description' => 'array',
        'seo_keywords' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: Active services only
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->where('status', 'published');
    }

    /**
     * Relationship: Projects associated with the service
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_service')->withTimestamps();
    }

    /**
     * Relationship: SEO Metadata
     */
    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
