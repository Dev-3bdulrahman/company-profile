<div class="legal-page">
    {{-- Page Header --}}
    <section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-30"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-primary/10 blur-3xl rounded-full"></div>
        <div class="relative max-w-4xl mx-auto text-center">
            <h1 class="text-5xl sm:text-6xl font-black mb-4 gradient-text">
                {{ $title }}
            </h1>
        </div>
    </section>

    <section class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto surface-card rounded-3xl p-8 sm:p-12">
            <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:font-black prose-p:font-medium prose-p:leading-relaxed">
                @if($content)
                    {!! $content !!}
                @else
                    <div class="text-center py-20 text-muted-foreground italic">
                        {{ __('Content is currently being updated.') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <x-sections.cta />
</div>
