<?php

namespace App\Http\Controllers\Web\Admin\Blog;

use App\Services\BlogService;
use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public ?int $post_id = null;
    public array $title = ['en' => '', 'ar' => ''];
    public string $slug = '';
    public array $excerpt = ['en' => '', 'ar' => ''];
    public array $content = ['en' => '', 'ar' => ''];
    public ?int $category_id = null;
    public $featured_image = null;
    public ?string $existing_featured_image = null;
    public string $status = 'draft';
    public ?string $published_at = null;
    public array $selected_tags = [];
    public string $active_lang = 'ar';
    public $editor_image = null;

    public function mount(BlogService $service, ?int $id = null): void
    {
        if ($id) {
            $post = \App\Models\Post::with(['tags'])->findOrFail($id);
            $this->post_id                 = $post->id;
            $this->title                   = $post->title ?? ['en' => '', 'ar' => ''];
            $this->slug                    = $post->slug ?? '';
            $this->excerpt                 = $post->excerpt ?? ['en' => '', 'ar' => ''];
            $this->content                 = $post->content ?? ['en' => '', 'ar' => ''];
            $this->category_id             = $post->category_id;
            $this->existing_featured_image = $post->featured_image;
            $this->status                  = $post->status;
            $this->published_at            = $post->published_at?->format('Y-m-d\TH:i');
            $this->selected_tags           = $post->tags->pluck('id')->toArray();
        }
    }

    public function updatedEditorImage(): void
    {
        if ($this->editor_image) {
            $path = $this->editor_image->store('editor/posts', 'public');
            $url = asset('storage/' . $path);
            $this->dispatch('editor-insert-image', ['url' => $url]);
            $this->editor_image = null;
        }
    }

    protected function rules(): array
    {
        return [
            'title.en'    => 'required|string|max:255',
            'title.ar'    => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:blog_posts,slug,' . $this->post_id,
            'status'      => 'required|in:draft,published,scheduled',
            'category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|image|max:3072',
        ];
    }

    public function save(BlogService $service): void
    {
        $this->validate();

        $data = [
            'title'          => $this->title,
            'slug'           => $this->slug ?: null,
            'excerpt'        => $this->excerpt,
            'content'        => $this->content,
            'category_id'    => $this->category_id,
            'status'         => $this->status,
            'published_at'   => $this->published_at,
            'tag_ids'        => $this->selected_tags,
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('blog/posts', 'public');
        }

        $post = $service->savePost($data, $this->post_id);

        $this->dispatch('notify', ['type' => 'success', 'message' => __('Post saved successfully!')]);
        $this->redirect(route('admin.blog'), navigate: true);
    }

    public function render(BlogService $service)
    {
        return view('livewire.admin.blog.form', [
            'categories'   => $service->listCategories(),
            'tags'         => $service->listTags(),
            'servicesList' => Service::active()->whereNotNull('slug')->orderBy('sort_order')->get(),
        ])->title($this->post_id ? __('Edit Post') : __('Add Post'));
    }
}
