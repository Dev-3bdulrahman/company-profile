<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogTag extends Model
{
    use HasTranslations;

    protected $table = 'blog_tags';

    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'name' => 'array',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'blog_post_tag', 'tag_id', 'post_id');
    }
}
