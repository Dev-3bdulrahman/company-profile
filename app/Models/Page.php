<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'seo_title',
        'seo_description',
        'featured_image',
        'is_active',
        'is_system',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'seo_title' => 'array',
        'seo_description' => 'array',
        'is_active' => 'boolean',
        'is_system' => 'boolean',
        'sort_order' => 'integer',
    ];
}
