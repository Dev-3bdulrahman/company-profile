<?php

namespace App\Http\Controllers\Web\Admin\HomeContent;

use App\Services\HomeSectionService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('CTA Section')]
class Cta extends Component
{
    public string $title_ar = '';
    public string $title_en = '';
    public string $subtitle_ar = '';
    public string $subtitle_en = '';
    public string $button_ar = '';
    public string $button_en = '';

    public function mount(HomeSectionService $service): void
    {
        $data = $service->getRaw()->keyBy('key')->get('cta')?->content ?? [];
        $this->title_ar    = $data['title']['ar'] ?? '';
        $this->title_en    = $data['title']['en'] ?? '';
        $this->subtitle_ar = $data['subtitle']['ar'] ?? '';
        $this->subtitle_en = $data['subtitle']['en'] ?? '';
        $this->button_ar   = $data['button']['ar'] ?? '';
        $this->button_en   = $data['button']['en'] ?? '';
    }

    public function save(HomeSectionService $service): void
    {
        $service->upsert('cta', [
            'title'    => ['ar' => $this->title_ar,    'en' => $this->title_en],
            'subtitle' => ['ar' => $this->subtitle_ar, 'en' => $this->subtitle_en],
            'button'   => ['ar' => $this->button_ar,   'en' => $this->button_en],
        ]);
        $this->dispatch('notify', ['type' => 'success', 'message' => __('Saved successfully.')]);
    }

    public function render()
    {
        return view('livewire.admin.home-content.cta');
    }
}
