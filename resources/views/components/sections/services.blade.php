@props(['services' => null, 'eyebrow' => null, 'title' => null, 'subtitle' => null, 'showTitle' => true])

@php
    $homeSectionService = app(\App\Services\HomeSectionService::class);
    $sections = $homeSectionService->getAll();
    $eyebrow  = $eyebrow  ?? $sections['services_section']['eyebrow'];
    $title    = $title    ?? $sections['services_section']['title'];
    $subtitle = $subtitle ?? $sections['services_section']['subtitle'];
    $services = $services ?? \App\Models\Service::where('is_active', true)->orderBy('sort_order')->take(6)->get();
@endphp

<section id="services" class="py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        @if($showTitle)
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-sm font-semibold text-primary mb-4 uppercase tracking-widest">
                {{ $eyebrow }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-black mb-4">{{ $title }}</h2>
            <p class="text-lg text-muted-foreground">{{ $subtitle }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="group surface-card rounded-2xl p-8 hover:border-primary/40 transition-all duration-500 hover:-translate-y-1 block">
                <div class="w-14 h-14 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-all">
                     @php
                        $icons = [
                            'padel' => 'trophy',
                            'tennis' => 'circle-dot',
                            'football' => 'goal',
                            'cricket' => 'target',
                            'lighting' => 'lightbulb',
                            'maintenance' => 'wrench'
                        ];
                        $icon = $icons[$service->slug] ?? 'layout';
                     @endphp
                     <i data-lucide="{{ $icon }}" class="w-6 h-6 text-primary group-hover:text-primary-foreground"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">{{ $service->getTranslation('title') }}</h3>
                <p class="text-muted-foreground leading-relaxed">{{ $service->getTranslation('short_description') ?: $service->getTranslation('description') }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
