<?php

namespace App\Http\Controllers\Web\Admin\HomeContent;

use App\Services\HomeSectionService;
use App\Models\SiteSetting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
#[Title('Hero Section')]
class Hero extends Component
{
    use WithFileUploads;

    public $hero_image = null;
    public string $existing_hero_image = '';
    public string $eyebrow_ar = '';
    public string $eyebrow_en = '';
    public string $title1_ar = '';
    public string $title1_en = '';
    public string $title2_ar = '';
    public string $title2_en = '';
    public string $subtitle_ar = '';
    public string $subtitle_en = '';
    public string $cta1_ar = '';
    public string $cta1_en = '';
    public string $cta1_url = '';
    public string $cta2_ar = '';
    public string $cta2_en = '';
    public string $cta2_url = '';

    public function mount(HomeSectionService $service): void
    {
        $data = $service->getRaw()->keyBy('key')->get('hero')?->content ?? [];
        $this->eyebrow_ar  = $data['eyebrow']['ar'] ?? '';
        $this->eyebrow_en  = $data['eyebrow']['en'] ?? '';
        $this->title1_ar   = $data['title1']['ar'] ?? '';
        $this->title1_en   = $data['title1']['en'] ?? '';
        $this->title2_ar   = $data['title2']['ar'] ?? '';
        $this->title2_en   = $data['title2']['en'] ?? '';
        $this->subtitle_ar = $data['subtitle']['ar'] ?? '';
        $this->subtitle_en = $data['subtitle']['en'] ?? '';
        $this->cta1_ar     = $data['cta1']['ar'] ?? '';
        $this->cta1_en     = $data['cta1']['en'] ?? '';
        $this->cta1_url    = $data['cta1_url'] ?? '#contact';
        $this->cta2_ar     = $data['cta2']['ar'] ?? '';
        $this->cta2_en     = $data['cta2']['en'] ?? '';
        $this->cta2_url    = $data['cta2_url'] ?? '#projects';

        // Hero image from SiteSettings
        $this->existing_hero_image = SiteSetting::getValue('hero_image') ?? '';
    }

    public function save(HomeSectionService $service): void
    {
        $service->upsert('hero', [
            'eyebrow'  => ['ar' => $this->eyebrow_ar,  'en' => $this->eyebrow_en],
            'title1'   => ['ar' => $this->title1_ar,   'en' => $this->title1_en],
            'title2'   => ['ar' => $this->title2_ar,   'en' => $this->title2_en],
            'subtitle' => ['ar' => $this->subtitle_ar, 'en' => $this->subtitle_en],
            'cta1'     => ['ar' => $this->cta1_ar,     'en' => $this->cta1_en],
            'cta1_url' => $this->cta1_url,
            'cta2'     => ['ar' => $this->cta2_ar,     'en' => $this->cta2_en],
            'cta2_url' => $this->cta2_url,
        ]);

        // Handle hero image upload
        if ($this->hero_image) {
            $path = $this->hero_image->store('hero', 'public');
            SiteSetting::updateOrCreate(['key' => 'hero_image'], ['value' => $path]);
            $this->existing_hero_image = $path;
            $this->hero_image = null;
        }

        $this->dispatch('notify', ['type' => 'success', 'message' => __('Saved successfully.')]);
    }

    public function render()
    {
        return view('livewire.admin.home-content.hero');
    }
}
