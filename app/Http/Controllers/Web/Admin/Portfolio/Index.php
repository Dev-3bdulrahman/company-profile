<?php

namespace App\Http\Controllers\Web\Admin\Portfolio;

use Livewire\Component;
use App\Services\Internal\PortfolioManagementService;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('إدارة المشاريع')]
class Index extends Component
{
    use WithFileUploads;

    public array $portfolioItems = [];
    public bool $showModal = false;
    public ?int $portfolioId = null;

    public string $title_ar = '';
    public string $title_en = '';
    public string $description_ar = '';
    public string $description_en = '';
    public string $year = '';
    public $image;
    public ?string $existing_image = null;
    public bool $is_active = true;
    public int $sort_order = 0;

    public function mount(PortfolioManagementService $service)
    {
        $this->portfolioItems = $service->getAllPortfolioItems()->toArray();
    }

    public function create()
    {
        $this->resetForm();
        $this->year = date('Y');
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $this->resetForm();
        $this->portfolioId = $id;
        
        $item = collect($this->portfolioItems)->firstWhere('id', $id);
        if ($item) {
            $item = (array) $item;
            $this->title_ar = $item['title']['ar'] ?? '';
            $this->title_en = $item['title']['en'] ?? '';
            $this->description_ar = $item['description']['ar'] ?? '';
            $this->description_en = $item['description']['en'] ?? '';
            $this->year = $item['year'];
            $this->existing_image = $item['image'] ?? null;
            $this->is_active = (bool) ($item['is_active'] ?? true);
            $this->sort_order = (int) ($item['sort_order'] ?? 0);
        }
        
        $this->showModal = true;
    }

    public function save(PortfolioManagementService $service)
    {
        $this->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'year' => 'required|numeric|min:1900|max:' . (date('Y') + 10),
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => ['ar' => $this->title_ar, 'en' => $this->title_en],
            'description' => ['ar' => $this->description_ar, 'en' => $this->description_en],
            'year' => $this->year,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('portfolio', 'public');
        }

        $service->savePortfolioItem($data, $this->portfolioId);

        $this->showModal = false;
        $this->portfolioItems = $service->getAllPortfolioItems()->toArray();
        
        $this->dispatch('notify', ['type' => 'success', 'message' => __('Portfolio item saved successfully')]);
    }

    public function toggleStatus(int $id, PortfolioManagementService $service)
    {
        $item = collect($this->portfolioItems)->firstWhere('id', $id);
        if ($item) {
            $service->savePortfolioItem(['is_active' => !($item['is_active'] ?? true)], $id);
            $this->portfolioItems = $service->getAllPortfolioItems()->toArray();
            $this->dispatch('notify', ['type' => 'success', 'message' => __('Status updated successfully')]);
        }
    }

    public function reorder(array $items, PortfolioManagementService $service)
    {
        foreach ($items as $item) {
            $service->savePortfolioItem(['sort_order' => $item['order']], $item['id']);
        }
        
        $service->rebalanceOrders();
        $this->portfolioItems = $service->getAllPortfolioItems()->toArray();
    }

    public function delete(PortfolioManagementService $service, $id)
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if ($targetId) {
            $service->deletePortfolioItem($targetId);
        }

        $this->portfolioItems = $service->getAllPortfolioItems()->toArray();
        $this->dispatch('notify', ['type' => 'success', 'message' => __('Portfolio item deleted successfully')]);
    }

    public function resetForm()
    {
        $this->portfolioId = null;
        $this->title_ar = '';
        $this->title_en = '';
        $this->description_ar = '';
        $this->description_en = '';
        $this->year = '';
        $this->image = null;
        $this->existing_image = null;
        $this->is_active = true;
        $this->sort_order = 0;
    }

    public function render()
    {
        return view('livewire.admin.portfolio.index');
    }
}
