<?php

namespace App\Http\Controllers\Web;

use App\Services\BlogService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Blog extends Component
{
    public $posts;
    public $categories;

    #[Layout('layouts.guest')]
    public function mount(BlogService $blogService)
    {
        $this->posts = $blogService->listPosts(['published_only' => true]);
        $this->categories = $blogService->listCategories();
    }

    public function render()
    {
        return view('livewire.blog');
    }
}
