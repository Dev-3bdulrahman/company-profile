<?php

namespace App\Http\Controllers\Web;

use App\Services\BlogService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class BlogShow extends Component
{
    public $post;
    public $relatedPosts;

    #[Layout('layouts.guest')]
    public function mount(BlogService $blogService, $slug)
    {
        $this->post = $blogService->getPostBySlug($slug);

        if (!$this->post || ($this->post->status !== 'published' && !auth()->check())) {
            abort(404);
        }

        $this->relatedPosts = $blogService->listPosts([
            'published_only' => true,
            'category_id' => $this->post->category_id
        ])->where('id', '!=', $this->post->id)->take(3);
    }

    public function render()
    {
        return view('livewire.blog-show');
    }
}
