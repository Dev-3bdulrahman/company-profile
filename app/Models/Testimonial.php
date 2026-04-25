<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Testimonial extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'role',
        'text',
        'stars',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'role' => 'array',
        'text' => 'array',
        'stars' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
