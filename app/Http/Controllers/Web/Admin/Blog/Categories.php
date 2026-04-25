<?php

namespace App\Http\Controllers\Web\Admin\Blog;

use App\Services\BlogService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Categories extends Component
{
    public string $name_ar = '';
    public string $name_en = '';
    public string $slug = '';
    public ?int $category_id = null;
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?int $deletingId = null;

    protected function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ];
    }

    public function create(): void
    {
        $this->reset(['category_id', 'name_ar', 'name_en', 'slug']);
        $this->showModal = true;
    }

    public function edit(int $id, BlogService $service): void
    {
        $cat = $service->listCategories()->firstWhere('id', $id);
        if ($cat) {
            $this->category_id = $cat->id;
            $this->name_ar = $cat->name['ar'] ?? '';
            $this->name_en = $cat->name['en'] ?? '';
            $this->slug = $cat->slug ?? '';
        }
        $this->showModal = true;
    }

    public function save(BlogService $service): void
    {
        $this->validate();
        $service->saveCategory([
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'slug' => $this->slug ?: null,
        ], $this->category_id);

        $this->showModal = false;
        $this->reset(['category_id', 'name_ar', 'name_en', 'slug']);
        $this->dispatch('notify', ['type' => 'success', 'message' => __('Category saved successfully.')]);
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(BlogService $service): void
    {
        if ($this->deletingId) {
            \App\Models\BlogCategory::findOrFail($this->deletingId)->delete();
        }
        $this->showDeleteModal = false;
        $this->deletingId = null;
        $this->dispatch('notify', ['type' => 'success', 'message' => __('Category deleted successfully.')]);
    }

    public function render(BlogService $service)
    {
        return view('livewire.admin.blog.categories', [
            'categories' => $service->listCategories(),
        ])->title(__('Blog Categories'));
    }
}
