@props(['testimonials', 'eyebrow', 'title'])

<section id="testimonials" class="py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-sm font-semibold text-primary mb-4">
                {{ $eyebrow }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-black">{{ $title }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="surface-card rounded-2xl p-8 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-6 end-6 w-10 h-10 text-primary/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 2.5 1 4 2 5.013a10.28 10.28 0 0 1-4 1.013v2zm14 0c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 2.5 1 4 2 5.013a10.28 10.28 0 0 1-4 1.013v2z"/></svg>
                <div class="flex gap-0.5 mb-4">
                    @for($i=0; $i<5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $i < $testimonial->stars ? 'fill-accent text-accent' : 'text-muted' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    @endfor
                </div>
                <p class="text-foreground/90 leading-relaxed mb-6 relative z-10">
                    "{{ $testimonial->getTranslation('text') }}"
                </p>
                <div class="border-t border-border pt-4">
                    <div class="font-bold">{{ $testimonial->getTranslation('name') }}</div>
                    <div class="text-sm text-muted-foreground">{{ $testimonial->getTranslation('role') }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
