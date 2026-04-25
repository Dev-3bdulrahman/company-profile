<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    use HasTranslations;

    protected $table = 'seo_metas';

    protected $fillable = [
        'seoable_id',
        'seoable_type',
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'robots',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'keywords' => 'array',
        'og_title' => 'array',
        'og_description' => 'array',
    ];

    /**
     * Relationship: The entity this SEO meta belongs to.
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
