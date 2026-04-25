<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display a listing of blog posts
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'tag_id', 'search']);
        $filters['published_only'] = true;
        
        $posts = $this->blogService->listPosts($filters);
        $categories = $this->blogService->listCategories();
        
        return view('web.blog.index', compact('posts', 'categories'));
    }

    /**
     * Display the specified blog post
     */
    public function show($slug)
    {
        $post = $this->blogService->getPostBySlug($slug);

        if (!$post || ($post->status !== 'published' && !auth()->check())) {
            abort(404);
        }

        return view('web.blog.show', compact('post'));
    }
}
