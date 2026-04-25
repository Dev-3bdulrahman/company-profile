<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class ProcessStep extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
