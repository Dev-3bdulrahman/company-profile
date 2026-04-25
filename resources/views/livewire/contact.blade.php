<div class="contact-page">
    {{-- Page Header --}}
    <section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-30"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-primary/10 blur-3xl rounded-full"></div>
        <div class="relative max-w-4xl mx-auto text-center">
            <h1 class="text-5xl sm:text-6xl font-black mb-4 gradient-text">
                {{ __('landing.nav.contact') }}
            </h1>
            <p class="text-lg text-muted-foreground max-w-2xl mx-auto font-medium">
                {{ __('landing.cta.subtitle') }}
            </p>
        </div>
    </section>

    @php
        $contactEmail = \App\Models\SiteSetting::getValue('contact_email');
        $contactPhone = \App\Models\SiteSetting::getValue('contact_phone');
        $whatsapp = \App\Models\SiteSetting::getValue('whatsapp');
    @endphp

    <x-sections.contact :contactEmail="$contactEmail" :contactPhone="$contactPhone" :whatsapp="$whatsapp" :showTitle="false" />

    <x-sections.cta />
</div>
