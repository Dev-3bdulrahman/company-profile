@props(['title' => null, 'subtitle' => null, 'button' => null])

@php
    $homeSectionService = app(\App\Services\HomeSectionService::class);
    $sections = $homeSectionService->getAll();
    $title    = $title    ?? $sections['cta']['title'];
    $subtitle = $subtitle ?? $sections['cta']['subtitle'];
    $button   = $button   ?? $sections['cta']['button'];
@endphp

<section id="cta" class="py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="relative surface-card rounded-3xl p-12 sm:p-16 text-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-transparent to-accent/10"></div>
            <div class="absolute -top-32 -end-32 w-64 h-64 rounded-full bg-primary/20 blur-3xl"></div>
            <div class="absolute -bottom-32 -start-32 w-64 h-64 rounded-full bg-accent/20 blur-3xl"></div>
            <div class="relative">
                <h2 class="text-4xl sm:text-5xl font-black mb-4">{{ $title }}</h2>
                <p class="text-lg text-muted-foreground max-w-xl mx-auto mb-8">{{ $subtitle }}</p>
                <a href="{{ route('contact') }}" wire:navigate
                   class="inline-flex items-center gap-2 bg-primary text-primary-foreground px-10 py-4 rounded-full text-lg font-black glow-primary hover:scale-105 active:scale-95 transition-all">
                    {{ $button }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" x2="19" y1="12" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
