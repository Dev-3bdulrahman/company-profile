<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class PortfolioItem extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 
        'slug', 
        'description', 
        'year', 
        'color', 
        'image', 
        'behance_url', 
        'behance_id', 
        'gallery', 
        'is_active', 
        'sort_order'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'gallery' => 'array',
    ];
}