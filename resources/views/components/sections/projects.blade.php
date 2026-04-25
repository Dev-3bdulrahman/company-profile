@props(['portfolio', 'eyebrow' => null, 'title' => null, 'subtitle' => null, 'showTitle' => true])

<section id="projects" class="py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        @if($showTitle && ($eyebrow || $title))
        <div class="text-center max-w-3xl mx-auto mb-16">
            @if($eyebrow)
            <div class="inline-block px-4 py-1.5 rounded-full bg-accent/10 border border-accent/20 text-sm font-semibold text-accent mb-4 uppercase tracking-widest">
                {{ $eyebrow }}
            </div>
            @endif
            @if($title)
            <h2 class="text-4xl sm:text-5xl font-black mb-4">{{ $title }}</h2>
            @endif
            @if($subtitle)
            <p class="text-lg text-muted-foreground">{{ $subtitle }}</p>
            @endif
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($portfolio as $item)
            <a href="{{ route('projects.show', $item->slug) }}" class="group relative aspect-[4/3] rounded-2xl overflow-hidden surface-card block">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->getTranslation('title') }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-transparent"></div>
                <div class="absolute inset-0 p-8 flex flex-col justify-end">
                    <div class="text-sm font-semibold text-primary mb-2">{{ $item->year }}</div>
                    <h3 class="text-2xl font-black mb-2">{{ $item->getTranslation('title') }}</h3>
                    <p class="text-muted-foreground line-clamp-2">{{ $item->getTranslation('description') }}</p>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('projects.index') }}" wire:navigate
               class="inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all uppercase tracking-widest text-sm">
                {{ __('landing.projects.view_all') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" x2="19" y1="12" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>
