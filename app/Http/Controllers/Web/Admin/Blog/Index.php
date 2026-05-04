<?php

namespace App\Http\Controllers\Web\Admin\Blog;

use App\Services\BlogService;
use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $blogService;

    public $post_id;
    public $title = ['en' => '', 'ar' => ''];
    public $slug;
    public $excerpt = ['en' => '', 'ar' => ''];
    public $content = ['en' => '', 'ar' => ''];
    public $category_id;
    public $featured_image;
    public $existing_featured_image;
    public $status = 'draft';
    public $published_at;
    public $selected_tags = [];
    public $selected_services = [];

    public $search = '';
    public $filterStatus = '';
    public $filterCategory = '';
    public $isModalOpen = false;

    public function boot(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    protected function rules(): array
    {
        return [
            'title.en'    => 'required|string|max:255',
            'title.ar'    => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:blog_posts,slug,' . $this->post_id,
            'status'      => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:blog_categories,id',
        ];
    }

    public function openModal(?int $id = null)
    {
        $this->resetFields();
        if ($id) $this->edit($id);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['post_id', 'slug', 'category_id', 'featured_image', 'existing_featured_image', 'published_at', 'selected_tags', 'selected_services']);
        $this->title   = ['en' => '', 'ar' => ''];
        $this->excerpt = ['en' => '', 'ar' => ''];
        $this->content = ['en' => '', 'ar' => ''];
        $this->status  = 'draft';
        $this->resetValidation();
    }

    public function edit(int $id)
    {
        $post = \App\Models\Post::with(['tags', 'services'])->findOrFail($id);

        $this->post_id                 = $post->id;
        $this->title                   = $post->title ?? ['en' => '', 'ar' => ''];
        $this->slug                    = $post->slug;
        $this->excerpt                 = $post->excerpt ?? ['en' => '', 'ar' => ''];
        $this->content                 = $post->content ?? ['en' => '', 'ar' => ''];
        $this->category_id             = $post->category_id;
        $this->existing_featured_image = $post->featured_image;
        $this->status                  = $post->status;
        $this->published_at            = $post->published_at?->format('Y-m-d\TH:i');
        $this->selected_tags           = $post->tags->pluck('id')->toArray();
        $this->selected_services       = $post->services->pluck('id')->toArray();
        $this->isModalOpen             = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title'          => $this->title,
            'slug'           => $this->slug,
            'excerpt'        => $this->excerpt,
            'content'        => $this->content,
            'category_id'    => $this->category_id,
            'featured_image' => $this->featured_image,
            'status'         => $this->status,
            'published_at'   => $this->published_at,
            'tag_ids'        => $this->selected_tags,
            'service_ids'    => $this->selected_services,
        ];

        $this->blogService->savePost($data, $this->post_id);
        $this->closeModal();
        $this->dispatch('notify', ['message' => __('Post saved successfully!'), 'type' => 'success']);
    }

    public function delete($id)
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if ($targetId) {
            $this->blogService->deletePost($targetId);
            $this->dispatch('notify', ['message' => __('Post deleted successfully!'), 'type' => 'success']);
        }
    }

    public function toggleStatus($id)
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if (!$targetId) return;
        $post = \App\Models\Post::findOrFail($targetId);
        $post->status = $post->status === 'published' ? 'draft' : 'published';
        $post->save();
        $this->dispatch('notify', ['message' => __('Post status updated!'), 'type' => 'success']);
    }

    public function render()
    {
        $filters = ['search' => $this->search];
        if ($this->filterStatus)   $filters['status']      = $this->filterStatus;
        if ($this->filterCategory) $filters['category_id'] = $this->filterCategory;

        $posts        = $this->blogService->listPosts($filters);
        $categories   = $this->blogService->listCategories();
        $tags         = $this->blogService->listTags();
        $servicesList = Service::active()->whereNotNull('slug')->orderBy('sort_order')->get();

        return view('livewire.admin.blog.index', compact('posts', 'categories', 'tags', 'servicesList'))
            ->title(__('Manage Blog'));
    }
}
