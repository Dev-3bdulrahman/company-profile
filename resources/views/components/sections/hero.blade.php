@props(['heroTitle1', 'heroTitle2', 'heroSubtitle', 'heroCta1', 'heroCta1Url', 'heroCta2', 'heroCta2Url', 'heroEyebrow'])

@php
    $heroImagePath = \App\Models\SiteSetting::getValue('hero_image');
    $heroImageUrl  = $heroImagePath
        ? asset('storage/' . $heroImagePath)
        : asset('assets/landing/hero-padel.jpg');
@endphp

<section id="home" class="relative min-h-[92vh] flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $heroImageUrl }}" alt="Hero" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-background/70 via-background/85 to-background"></div>
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                <span class="text-sm font-semibold text-primary uppercase tracking-wider">{{ $heroEyebrow }}</span>
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-[1.05] mb-6">
                <span class="block text-foreground">{{ $heroTitle1 }}</span>
                <span class="block gradient-text mt-2">{{ $heroTitle2 }}</span>
            </h1>

            <p class="text-lg sm:text-xl text-muted-foreground max-w-2xl mb-10 leading-relaxed">
                {{ $heroSubtitle }}
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ $heroCta1Url }}" class="bg-primary text-primary-foreground px-8 py-4 rounded-full text-lg font-black glow-primary hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                    {{ $heroCta1 }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" x2="19" y1="12" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ $heroCta2Url }}" class="bg-transparent border-2 border-border hover:border-primary/50 text-foreground px-8 py-4 rounded-full text-lg font-black transition-all">
                    {{ $heroCta2 }}
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-background to-transparent pointer-events-none"></div>
</section>
