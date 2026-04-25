<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Post extends Model
{
    use HasTranslations;

    protected $table = 'blog_posts';

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'content' => 'array',
        'seo_title' => 'array',
        'seo_description' => 'array',
        'seo_keywords' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * Scope: Published posts only
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Relationship: Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Relationship: Author
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Relationship: Tags
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'post_id', 'tag_id');
    }

    /**
     * Relationship: Related Services
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'blog_post_service', 'post_id', 'service_id');
    }

    /**
     * Relationship: SEO Metadata
     */
    public function seoMeta(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
