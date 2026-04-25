<div class="services-page">
    {{-- Page Header --}}
    <section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-30"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-primary/10 blur-3xl rounded-full"></div>
        <div class="relative max-w-4xl mx-auto text-center">
            <h1 class="text-5xl sm:text-6xl font-black mb-4 gradient-text">
                {{ __('landing.services.title') }}
            </h1>
            <p class="text-lg text-muted-foreground max-w-2xl mx-auto font-medium">
                {{ __('landing.services.subtitle') }}
            </p>
        </div>
    </section>

    <x-sections.services :services="$services" :showTitle="false" />

    <x-sections.process />

    <x-sections.cta />
</div>
