<?php

namespace App\Http\Controllers\Web\Admin\Services;

use App\Models\Service;
use App\Services\ServiceService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

    protected $servicesService;

    // Form fields
    public $service_id;
    public $title = ['en' => '', 'ar' => ''];
    public $slug;
    public $short_description = ['en' => '', 'ar' => ''];
    public $full_description = ['en' => '', 'ar' => ''];
    public $hero_image;
    public $existing_hero_image;
    public $gallery_uploads = [];
    public $existing_gallery = [];
    public $features = [];
    public $cta_title = ['en' => '', 'ar' => ''];
    public $cta_text = ['en' => '', 'ar' => ''];
    public $cta_url;
    public $faqs = [];
    public $seo_title = ['en' => '', 'ar' => ''];
    public $seo_description = ['en' => '', 'ar' => ''];
    public $seo_keywords = ['en' => '', 'ar' => ''];
    public $status = 'draft';
    public $sort_order = 0;
    public $is_active = true;
    public $selected_projects = [];

    public $search = '';
    public $isModalOpen = false;

    public function boot(ServiceService $servicesService)
    {
        $this->servicesService = $servicesService;
    }

    protected function rules()
    {
        return [
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $this->service_id,
            'status' => 'required|in:draft,published',
            'is_active' => 'boolean',
        ];
    }

    public function render()
    {
        $services = Service::where('title->' . app()->getLocale(), 'like', '%' . $this->search . '%')
            ->orWhere('slug', 'like', '%' . $this->search . '%')
            ->orderBy('sort_order', 'asc')
            ->paginate(10);

        return view('livewire.admin.services.index', compact('services'))
            ->title(__('Manage Services'));
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
        $this->reset([
            'service_id', 'title', 'slug', 'short_description', 'full_description',
            'hero_image', 'existing_hero_image', 'gallery_uploads', 'existing_gallery',
            'features', 'cta_title', 'cta_text', 'cta_url', 'faqs',
            'seo_title', 'seo_description', 'seo_keywords', 'status',
            'sort_order', 'is_active', 'selected_projects'
        ]);
        
        $this->title = ['en' => '', 'ar' => ''];
        $this->short_description = ['en' => '', 'ar' => ''];
        $this->full_description = ['en' => '', 'ar' => ''];
        $this->cta_title = ['en' => '', 'ar' => ''];
        $this->cta_text = ['en' => '', 'ar' => ''];
        $this->seo_title = ['en' => '', 'ar' => ''];
        $this->seo_description = ['en' => '', 'ar' => ''];
        $this->seo_keywords = ['en' => '', 'ar' => ''];
    }

    public function edit($id)
    {
        $service = $this->servicesService->getServiceById($id);
        
        $this->service_id = $service->id;
        $this->title = $service->title;
        $this->slug = $service->slug;
        $this->short_description = $service->short_description ?? ['en' => '', 'ar' => ''];
        $this->full_description = $service->full_description ?? ['en' => '', 'ar' => ''];
        $this->existing_hero_image = $service->hero_image;
        $this->existing_gallery = $service->gallery ?? [];
        $this->features = $service->features ?? [];
        $this->cta_title = $service->cta_title ?? ['en' => '', 'ar' => ''];
        $this->cta_text = $service->cta_text ?? ['en' => '', 'ar' => ''];
        $this->cta_url = $service->cta_url;
        $this->faqs = $service->faqs ?? [];
        $this->seo_title = $service->seo_title ?? ['en' => '', 'ar' => ''];
        $this->seo_description = $service->seo_description ?? ['en' => '', 'ar' => ''];
        $this->seo_keywords = $service->seo_keywords ?? ['en' => '', 'ar' => ''];
        $this->status = $service->status;
        $this->sort_order = $service->sort_order;
        $this->is_active = $service->is_active;
        $this->selected_projects = [];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'features' => $this->features,
            'cta_title' => $this->cta_title,
            'cta_text' => $this->cta_text,
            'cta_url' => $this->cta_url,
            'faqs' => $this->faqs,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $this->seo_keywords,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'hero_image' => $this->hero_image,
            'gallery_uploads' => $this->gallery_uploads,
            'gallery' => $this->existing_gallery,
        ];

        $this->servicesService->saveService($data, $this->service_id);

        $this->closeModal();
        $this->dispatch('notify', ['message' => __('Service saved successfully!'), 'type' => 'success']);
    }

    public function delete($id)
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if ($targetId) {
            $this->servicesService->deleteService($targetId);
            $this->dispatch('notify', ['message' => __('Service deleted successfully!'), 'type' => 'success']);
        }
    }

    public function addFeature()
    {
        $this->features[] = ['en' => '', 'ar' => ''];
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function addFaq()
    {
        $this->faqs[] = [
            'question' => ['en' => '', 'ar' => ''],
            'answer' => ['en' => '', 'ar' => '']
        ];
    }

    public function removeFaq($index)
    {
        unset($this->faqs[$index]);
        $this->faqs = array_values($this->faqs);
    }

    public function removeGalleryImage($index)
    {
        unset($this->existing_gallery[$index]);
        $this->existing_gallery = array_values($this->existing_gallery);
    }
}
