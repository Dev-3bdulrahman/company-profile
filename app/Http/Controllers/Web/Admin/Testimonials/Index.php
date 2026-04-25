<?php

namespace App\Http\Controllers\Web\Admin\Testimonials;

use App\Models\Testimonial;
use App\Services\TestimonialService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    protected $testimonialService;

    // Form fields
    public $testimonial_id;
    public $name = ['en' => '', 'ar' => ''];
    public $role = ['en' => '', 'ar' => ''];
    public $text = ['en' => '', 'ar' => ''];
    public $stars = 5;
    public $sort_order = 0;
    public $is_active = true;

    public $search = '';
    public $isModalOpen = false;

    public function boot(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    protected function rules()
    {
        return [
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'text.en' => 'required|string',
            'text.ar' => 'required|string',
            'stars' => 'required|integer|min:1|max:5',
        ];
    }

    public function render()
    {
        $testimonials = Testimonial::where('name->' . app()->getLocale(), 'like', '%' . $this->search . '%')
            ->orderBy('sort_order', 'asc')
            ->paginate(10);

        return view('livewire.admin.testimonials.index', compact('testimonials'))
            ->title(__('Manage Testimonials'));
    }

    public function openModal($id = null)
    {
        $this->resetFields();
        if ($id) {
            $this->edit($id);
        }
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['testimonial_id', 'name', 'role', 'text', 'stars', 'sort_order', 'is_active']);
        $this->name = ['en' => '', 'ar' => ''];
        $this->role = ['en' => '', 'ar' => ''];
        $this->text = ['en' => '', 'ar' => ''];
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $this->testimonial_id = $testimonial->id;
        $this->name = $testimonial->name;
        $this->role = $testimonial->role ?? ['en' => '', 'ar' => ''];
        $this->text = $testimonial->text;
        $this->stars = $testimonial->stars;
        $this->sort_order = $testimonial->sort_order;
        $this->is_active = $testimonial->is_active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'role' => $this->role,
            'text' => $this->text,
            'stars' => $this->stars,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        $this->testimonialService->saveTestimonial($data, $this->testimonial_id);

        $this->closeModal();
        $this->dispatch('notify', ['message' => __('Testimonial saved successfully!'), 'type' => 'success']);
    }

    public function delete($id)
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if ($targetId) {
            $this->testimonialService->deleteTestimonial($targetId);
            $this->dispatch('notify', ['message' => __('Testimonial deleted successfully!'), 'type' => 'success']);
        }
    }

    public function toggleStatus($id)
    {
        $this->testimonialService->toggleStatus($id);
    }
}
