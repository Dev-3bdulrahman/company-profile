@props(['steps' => null, 'eyebrow' => null, 'title' => null])

@php
    $homeSectionService = app(\App\Services\HomeSectionService::class);
    $sections = $homeSectionService->getAll();
    $eyebrow = $eyebrow ?? $sections['process_section']['eyebrow'];
    $title   = $title   ?? $sections['process_section']['title'];
    $steps   = $steps   ?? \App\Models\ProcessStep::where('is_active', true)->orderBy('sort_order')->get();
@endphp

<section id="process" class="py-24 px-4 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 grid-pattern opacity-30 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto relative">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block px-4 py-1.5 rounded-full bg-accent/10 border border-accent/20 text-sm font-semibold text-accent mb-4 uppercase tracking-widest">
                {{ $eyebrow }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-black mb-4">{{ $title }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($steps as $index => $step)
            <div class="surface-card rounded-2xl p-8 h-full">
                <div class="text-6xl font-black gradient-text mb-4 leading-none">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </div>
                <h3 class="text-xl font-bold mb-3">{{ $step->getTranslation('title') }}</h3>
                <p class="text-muted-foreground">{{ $step->getTranslation('description') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
