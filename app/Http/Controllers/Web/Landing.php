<?php

namespace App\Http\Controllers\Web;

use App\Models\Service;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\ProcessStep;
use App\Models\SiteSetting;
use App\Services\HomeSectionService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class Landing extends Component
{
    public function render(HomeSectionService $homeSectionService)
    {
        $sections = $homeSectionService->getAll();

        $services   = Service::where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $projects   = PortfolioItem::where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        $processSteps = ProcessStep::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.landing', compact('sections', 'services', 'projects', 'testimonials', 'processSteps'))
            ->title(SiteSetting::getValue('seo_title', SiteSetting::getValue('site_name', config('app.name'))));
    }
}
