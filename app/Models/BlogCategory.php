<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    use HasTranslations;

    protected $table = 'blog_categories';

    protected $fillable = ['name', 'slug', 'description'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
