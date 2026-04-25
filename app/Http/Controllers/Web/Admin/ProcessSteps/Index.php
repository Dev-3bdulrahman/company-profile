<?php

namespace App\Http\Controllers\Web\Admin\ProcessSteps;

use App\Models\ProcessStep;
use App\Services\ProcessStepService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    protected $processStepService;

    // Form fields
    public $step_id;
    public $title = ['en' => '', 'ar' => ''];
    public $description = ['en' => '', 'ar' => ''];
    public $icon;
    public $sort_order = 0;
    public $is_active = true;

    public $search = '';
    public $isModalOpen = false;

    public function boot(ProcessStepService $processStepService)
    {
        $this->processStepService = $processStepService;
    }

    protected function rules()
    {
        return [
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
        ];
    }

    public function render()
    {
        $steps = ProcessStep::where('title->' . app()->getLocale(), 'like', '%' . $this->search . '%')
            ->orderBy('sort_order', 'asc')
            ->paginate(10);

        return view('livewire.admin.process-steps.index', compact('steps'))
            ->title(__('Manage Process Steps'));
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
        $this->reset(['step_id', 'title', 'description', 'icon', 'sort_order', 'is_active']);
        $this->title = ['en' => '', 'ar' => ''];
        $this->description = ['en' => '', 'ar' => ''];
    }

    public function edit($id)
    {
        $step = ProcessStep::findOrFail($id);
        $this->step_id = $step->id;
        $this->title = $step->title;
        $this->description = $step->description;
        $this->icon = $step->icon;
        $this->sort_order = $step->sort_order;
        $this->is_active = $step->is_active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        $this->processStepService->saveProcessStep($data, $this->step_id);

        $this->closeModal();
        $this->dispatch('notify', ['message' => __('Process step saved successfully!'), 'type' => 'success']);
    }

    public function delete($id)
    {
        $targetId = is_array($id) ? ($id['id'] ?? null) : $id;
        if ($targetId) {
            $this->processStepService->deleteProcessStep($targetId);
            $this->dispatch('notify', ['message' => __('Process step deleted successfully!'), 'type' => 'success']);
        }
    }

    public function toggleStatus($id)
    {
        $this->processStepService->toggleStatus($id);
    }
}
