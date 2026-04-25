<?php

namespace App\Http\Controllers\Web\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Form extends Component
{
    use WithFileUploads;

    public ?int $page_id = null;
    public array $title = ['ar' => '', 'en' => ''];
    public string $slug = '';
    public array $content = ['ar' => '', 'en' => ''];
    public bool $is_active = true;
    public int $sort_order = 0;
    public string $active_lang = 'ar';
    public $featured_image = null;
    public ?string $existing_featured_image = null;
    public $editor_image = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $page = Page::findOrFail($id);
            $this->page_id = $page->id;
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->content = $page->content;
            $this->is_active = $page->is_active;
            $this->sort_order = $page->sort_order;
            $this->existing_featured_image = $page->featured_image;
        }
    }

    public function updatedEditorImage(): void
    {
        if ($this->editor_image) {
            $path = $this->editor_image->store('editor/pages', 'public');
            $url = asset('storage/' . $path);
            $this->dispatch('editor-insert-image', ['url' => $url]);
            $this->editor_image = null;
        }
    }

    protected function rules(): array
    {
        return [
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $this->page_id,
            'content.ar' => 'nullable|string',
            'content.en' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'featured_image' => 'nullable|image|max:3072',
        ];
    }

    public function updatedTitleEn($value): void
    {
        if (!$this->page_id) {
            $this->slug = Str::slug($value);
        }
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->featured_image) {
            if ($this->page_id) {
                $oldPage = Page::find($this->page_id);
                if ($oldPage && $oldPage->featured_image) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPage->featured_image);
                }
            }
            $data['featured_image'] = $this->featured_image->store('pages', 'public');
        }

        Page::updateOrCreate(
            ['id' => $this->page_id],
            $data
        );

        $this->dispatch('notify', ['type' => 'success', 'message' => 'تم حفظ الصفحة بنجاح']);
        $this->redirect(route('admin.pages'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.pages.form')
            ->title($this->page_id ? 'تعديل صفحة' : 'إضافة صفحة');
    }
}
