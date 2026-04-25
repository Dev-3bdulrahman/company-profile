<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'color', 'image', 'is_active', 'sort_order', 'gallery', 'price', 'currency', 'status'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'gallery' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'price' => 'decimal:2',
    ];
}
