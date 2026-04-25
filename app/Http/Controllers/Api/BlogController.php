<?php

namespace App\Http\Controllers\Api;

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
     * API Placeholder for listing posts
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'tag_id', 'search']);
        $filters['published_only'] = true;
        
        $posts = $this->blogService->listPosts($filters);
        
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * API Placeholder for single post
     */
    public function show($slug)
    {
        $post = $this->blogService->getPostBySlug($slug);
        
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }
}
