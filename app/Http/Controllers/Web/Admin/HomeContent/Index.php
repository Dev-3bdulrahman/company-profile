<?php

namespace App\Http\Controllers\Web\Admin\HomeContent;

use App\Services\HomeSectionService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('إدارة محتوى الرئيسية')]
class Index extends Component
{
    public string $hero_eyebrow_ar = '';
    public string $hero_eyebrow_en = '';
    public string $hero_title1_ar = '';
    public string $hero_title1_en = '';
    public string $hero_title2_ar = '';
    public string $hero_title2_en = '';
    public string $hero_subtitle_ar = '';
    public string $hero_subtitle_en = '';
    public string $hero_cta1_ar = '';
    public string $hero_cta1_en = '';
    public string $hero_cta2_ar = '';
    public string $hero_cta2_en = '';

    public string $stats_projects_count = '';
    public string $stats_projects_label_ar = '';
    public string $stats_projects_label_en = '';
    public string $stats_years_count = '';
    public string $stats_years_label_ar = '';
    public string $stats_years_label_en = '';
    public string $stats_countries_count = '';
    public string $stats_countries_label_ar = '';
    public string $stats_countries_label_en = '';
    public string $stats_clients_count = '';
    public string $stats_clients_label_ar = '';
    public string $stats_clients_label_en = '';

    public string $services_eyebrow_ar = '';
    public string $services_eyebrow_en = '';
    public string $services_title_ar = '';
    public string $services_title_en = '';
    public string $services_subtitle_ar = '';
    public string $services_subtitle_en = '';

    public string $process_eyebrow_ar = '';
    public string $process_eyebrow_en = '';
    public string $process_title_ar = '';
    public string $process_title_en = '';

    public string $projects_eyebrow_ar = '';
    public string $projects_eyebrow_en = '';
    public string $projects_title_ar = '';
    public string $projects_title_en = '';
    public string $projects_subtitle_ar = '';
    public string $projects_subtitle_en = '';

    public string $test_eyebrow_ar = '';
    public string $test_eyebrow_en = '';
    public string $test_title_ar = '';
    public string $test_title_en = '';

    public string $cta_title_ar = '';
    public string $cta_title_en = '';
    public string $cta_subtitle_ar = '';
    public string $cta_subtitle_en = '';
    public string $cta_button_ar = '';
    public string $cta_button_en = '';

    public string $activeTab = 'hero';

    public function mount(HomeSectionService $service): void
    {
        $raw = $service->getRaw()->keyBy('key');

        $hero = $raw->get('hero')?->content ?? [];
        $this->hero_eyebrow_ar  = $hero['eyebrow']['ar'] ?? '';
        $this->hero_eyebrow_en  = $hero['eyebrow']['en'] ?? '';
        $this->hero_title1_ar   = $hero['title1']['ar'] ?? '';
        $this->hero_title1_en   = $hero['title1']['en'] ?? '';
        $this->hero_title2_ar   = $hero['title2']['ar'] ?? '';
        $this->hero_title2_en   = $hero['title2']['en'] ?? '';
        $this->hero_subtitle_ar = $hero['subtitle']['ar'] ?? '';
        $this->hero_subtitle_en = $hero['subtitle']['en'] ?? '';
        $this->hero_cta1_ar     = $hero['cta1']['ar'] ?? '';
        $this->hero_cta1_en     = $hero['cta1']['en'] ?? '';
        $this->hero_cta2_ar     = $hero['cta2']['ar'] ?? '';
        $this->hero_cta2_en     = $hero['cta2']['en'] ?? '';

        $stats = $raw->get('stats')?->content ?? [];
        $this->stats_projects_count    = $stats['projects_count'] ?? '';
        $this->stats_projects_label_ar = $stats['projects_label']['ar'] ?? '';
        $this->stats_projects_label_en = $stats['projects_label']['en'] ?? '';
        $this->stats_years_count       = $stats['years_count'] ?? '';
        $this->stats_years_label_ar    = $stats['years_label']['ar'] ?? '';
        $this->stats_years_label_en    = $stats['years_label']['en'] ?? '';
        $this->stats_countries_count   = $stats['countries_count'] ?? '';
        $this->stats_countries_label_ar = $stats['countries_label']['ar'] ?? '';
        $this->stats_countries_label_en = $stats['countries_label']['en'] ?? '';
        $this->stats_clients_count     = $stats['clients_count'] ?? '';
        $this->stats_clients_label_ar  = $stats['clients_label']['ar'] ?? '';
        $this->stats_clients_label_en  = $stats['clients_label']['en'] ?? '';

        $srv = $raw->get('services_section')?->content ?? [];
        $this->services_eyebrow_ar  = $srv['eyebrow']['ar'] ?? '';
        $this->services_eyebrow_en  = $srv['eyebrow']['en'] ?? '';
        $this->services_title_ar    = $srv['title']['ar'] ?? '';
        $this->services_title_en    = $srv['title']['en'] ?? '';
        $this->services_subtitle_ar = $srv['subtitle']['ar'] ?? '';
        $this->services_subtitle_en = $srv['subtitle']['en'] ?? '';

        $proc = $raw->get('process_section')?->content ?? [];
        $this->process_eyebrow_ar = $proc['eyebrow']['ar'] ?? '';
        $this->process_eyebrow_en = $proc['eyebrow']['en'] ?? '';
        $this->process_title_ar   = $proc['title']['ar'] ?? '';
        $this->process_title_en   = $proc['title']['en'] ?? '';

        $proj = $raw->get('projects_section')?->content ?? [];
        $this->projects_eyebrow_ar  = $proj['eyebrow']['ar'] ?? '';
        $this->projects_eyebrow_en  = $proj['eyebrow']['en'] ?? '';
        $this->projects_title_ar    = $proj['title']['ar'] ?? '';
        $this->projects_title_en    = $proj['title']['en'] ?? '';
        $this->projects_subtitle_ar = $proj['subtitle']['ar'] ?? '';
        $this->projects_subtitle_en = $proj['subtitle']['en'] ?? '';

        $test = $raw->get('testimonials_section')?->content ?? [];
        $this->test_eyebrow_ar = $test['eyebrow']['ar'] ?? '';
        $this->test_eyebrow_en = $test['eyebrow']['en'] ?? '';
        $this->test_title_ar   = $test['title']['ar'] ?? '';
        $this->test_title_en   = $test['title']['en'] ?? '';

        $cta = $raw->get('cta')?->content ?? [];
        $this->cta_title_ar    = $cta['title']['ar'] ?? '';
        $this->cta_title_en    = $cta['title']['en'] ?? '';
        $this->cta_subtitle_ar = $cta['subtitle']['ar'] ?? '';
        $this->cta_subtitle_en = $cta['subtitle']['en'] ?? '';
        $this->cta_button_ar   = $cta['button']['ar'] ?? '';
        $this->cta_button_en   = $cta['button']['en'] ?? '';
    }

    public function save(HomeSectionService $service): void
    {
        $service->upsert('hero', [
            'eyebrow'  => ['ar' => $this->hero_eyebrow_ar,  'en' => $this->hero_eyebrow_en],
            'title1'   => ['ar' => $this->hero_title1_ar,   'en' => $this->hero_title1_en],
            'title2'   => ['ar' => $this->hero_title2_ar,   'en' => $this->hero_title2_en],
            'subtitle' => ['ar' => $this->hero_subtitle_ar, 'en' => $this->hero_subtitle_en],
            'cta1'     => ['ar' => $this->hero_cta1_ar,     'en' => $this->hero_cta1_en],
            'cta2'     => ['ar' => $this->hero_cta2_ar,     'en' => $this->hero_cta2_en],
        ]);

        $service->upsert('stats', [
            'projects_count'  => $this->stats_projects_count,
            'projects_label'  => ['ar' => $this->stats_projects_label_ar, 'en' => $this->stats_projects_label_en],
            'years_count'     => $this->stats_years_count,
            'years_label'     => ['ar' => $this->stats_years_label_ar,    'en' => $this->stats_years_label_en],
            'countries_count' => $this->stats_countries_count,
            'countries_label' => ['ar' => $this->stats_countries_label_ar, 'en' => $this->stats_countries_label_en],
            'clients_count'   => $this->stats_clients_count,
            'clients_label'   => ['ar' => $this->stats_clients_label_ar,  'en' => $this->stats_clients_label_en],
        ]);

        $service->upsert('services_section', [
            'eyebrow'  => ['ar' => $this->services_eyebrow_ar,  'en' => $this->services_eyebrow_en],
            'title'    => ['ar' => $this->services_title_ar,    'en' => $this->services_title_en],
            'subtitle' => ['ar' => $this->services_subtitle_ar, 'en' => $this->services_subtitle_en],
        ]);

        $service->upsert('process_section', [
            'eyebrow' => ['ar' => $this->process_eyebrow_ar, 'en' => $this->process_eyebrow_en],
            'title'   => ['ar' => $this->process_title_ar,   'en' => $this->process_title_en],
        ]);

        $service->upsert('projects_section', [
            'eyebrow'  => ['ar' => $this->projects_eyebrow_ar,  'en' => $this->projects_eyebrow_en],
            'title'    => ['ar' => $this->projects_title_ar,    'en' => $this->projects_title_en],
            'subtitle' => ['ar' => $this->projects_subtitle_ar, 'en' => $this->projects_subtitle_en],
        ]);

        $service->upsert('testimonials_section', [
            'eyebrow' => ['ar' => $this->test_eyebrow_ar, 'en' => $this->test_eyebrow_en],
            'title'   => ['ar' => $this->test_title_ar,   'en' => $this->test_title_en],
        ]);

        $service->upsert('cta', [
            'title'    => ['ar' => $this->cta_title_ar,    'en' => $this->cta_title_en],
            'subtitle' => ['ar' => $this->cta_subtitle_ar, 'en' => $this->cta_subtitle_en],
            'button'   => ['ar' => $this->cta_button_ar,   'en' => $this->cta_button_en],
        ]);

        $this->dispatch('notify', ['type' => 'success', 'message' => __('Home content saved successfully.')]);
    }

    public function render()
    {
        return view('livewire.admin.home-content.index');
    }
}
