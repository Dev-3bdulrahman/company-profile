<?php

namespace App\Services;

use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogService
{
    /**
     * List posts with optional filtering
     */
    public function listPosts(array $filters = []): Collection
    {
        $query = Post::with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc');

        if (!empty($filters['published_only'])) {
            $query->published();
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['tag_id'])) {
            $query->whereHas('tags', function($q) use ($filters) {
                $q->where('blog_tags.id', $filters['tag_id']);
            });
        }

        if (!empty($filters['search'])) {
            $locale = app()->getLocale();
            $query->where(function($q) use ($filters, $locale) {
                $q->where('title->' . $locale, 'like', '%' . $filters['search'] . '%')
                  ->orWhere('slug', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->get();
    }

    /**
     * Get a single post by slug
     */
    public function getPostBySlug(string $slug): ?Post
    {
        return Post::with(['category', 'author', 'tags', 'services'])
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Create or Update a post
     */
    public function savePost(array $data, ?int $id = null): Post
    {
        // Handle Slug
        if (empty($data['slug'])) {
            $title = is_array($data['title']) ? ($data['title']['en'] ?? reset($data['title'])) : $data['title'];
            $data['slug'] = Str::slug($title ?: 'post-' . time());
        }

        // Handle Featured Image
        if (isset($data['featured_image']) && $data['featured_image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($id) {
                $oldPost = Post::find($id);
                if ($oldPost && $oldPost->featured_image) {
                    Storage::disk('public')->delete($oldPost->featured_image);
                }
            }
            $data['featured_image'] = $data['featured_image']->store('blog/posts', 'public');
        }

        // Handle published_at if publishing
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = Carbon::now();
        }

        if ($id) {
            $post = Post::findOrFail($id);
            $post->update($data);
        } else {
            $data['author_id'] = $data['author_id'] ?? auth()->id();
            $post = Post::create($data);
        }

        // Sync Tags
        if (isset($data['tag_ids'])) {
            $post->tags()->sync($data['tag_ids']);
        }

        // Sync Services
        if (isset($data['service_ids'])) {
            $post->services()->sync($data['service_ids']);
        }

        return $post;
    }

    /**
     * Delete a post
     */
    public function deletePost(int $id): bool
    {
        $post = Post::findOrFail($id);
        
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        return $post->delete();
    }

    /**
     * Manage Categories
     */
    public function listCategories(): Collection
    {
        return BlogCategory::orderBy('name')->get();
    }

    public function saveCategory(array $data, ?int $id = null): BlogCategory
    {
        if (empty($data['slug'])) {
            $name = is_array($data['name']) ? ($data['name']['en'] ?? reset($data['name'])) : $data['name'];
            $data['slug'] = Str::slug($name);
        }

        if ($id) {
            $category = BlogCategory::findOrFail($id);
            $category->update($data);
        } else {
            $category = BlogCategory::create($data);
        }

        return $category;
    }

    /**
     * Manage Tags
     */
    public function listTags(): Collection
    {
        return BlogTag::orderBy('name')->get();
    }

    public function saveTag(array $data, ?int $id = null): BlogTag
    {
        if (empty($data['slug'])) {
            $name = is_array($data['name']) ? ($data['name']['en'] ?? reset($data['name'])) : $data['name'];
            $data['slug'] = Str::slug($name);
        }

        if ($id) {
            $tag = BlogTag::findOrFail($id);
            $tag->update($data);
        } else {
            $tag = BlogTag::create($data);
        }

        return $tag;
    }
}
