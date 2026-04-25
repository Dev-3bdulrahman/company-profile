<?php

namespace App\Http\Controllers\Web\Admin\HomeContent;

use App\Services\HomeSectionService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Stats Section')]
class Stats extends Component
{
    public string $projects_count = '';
    public string $projects_label_ar = '';
    public string $projects_label_en = '';
    public string $years_count = '';
    public string $years_label_ar = '';
    public string $years_label_en = '';
    public string $countries_count = '';
    public string $countries_label_ar = '';
    public string $countries_label_en = '';
    public string $clients_count = '';
    public string $clients_label_ar = '';
    public string $clients_label_en = '';

    public function mount(HomeSectionService $service): void
    {
        $data = $service->getRaw()->keyBy('key')->get('stats')?->content ?? [];
        $this->projects_count    = $data['projects_count'] ?? '';
        $this->projects_label_ar = $data['projects_label']['ar'] ?? '';
        $this->projects_label_en = $data['projects_label']['en'] ?? '';
        $this->years_count       = $data['years_count'] ?? '';
        $this->years_label_ar    = $data['years_label']['ar'] ?? '';
        $this->years_label_en    = $data['years_label']['en'] ?? '';
        $this->countries_count   = $data['countries_count'] ?? '';
        $this->countries_label_ar = $data['countries_label']['ar'] ?? '';
        $this->countries_label_en = $data['countries_label']['en'] ?? '';
        $this->clients_count     = $data['clients_count'] ?? '';
        $this->clients_label_ar  = $data['clients_label']['ar'] ?? '';
        $this->clients_label_en  = $data['clients_label']['en'] ?? '';
    }

    public function save(HomeSectionService $service): void
    {
        $service->upsert('stats', [
            'projects_count'  => $this->projects_count,
            'projects_label'  => ['ar' => $this->projects_label_ar, 'en' => $this->projects_label_en],
            'years_count'     => $this->years_count,
            'years_label'     => ['ar' => $this->years_label_ar,    'en' => $this->years_label_en],
            'countries_count' => $this->countries_count,
            'countries_label' => ['ar' => $this->countries_label_ar, 'en' => $this->countries_label_en],
            'clients_count'   => $this->clients_count,
            'clients_label'   => ['ar' => $this->clients_label_ar,  'en' => $this->clients_label_en],
        ]);
        $this->dispatch('notify', ['type' => 'success', 'message' => __('Saved successfully.')]);
    }

    public function render()
    {
        return view('livewire.admin.home-content.stats');
    }
}
