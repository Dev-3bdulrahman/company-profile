<div class="landing-page overflow-x-hidden">
    {{-- Hero --}}
    <x-sections.hero
        :heroEyebrow="$sections['hero']['eyebrow']"
        :heroTitle1="$sections['hero']['title1']"
        :heroTitle2="$sections['hero']['title2']"
        :heroSubtitle="$sections['hero']['subtitle']"
        :heroCta1="$sections['hero']['cta1']"
        :heroCta1Url="$sections['hero']['cta1_url'] ?? '#contact'"
        :heroCta2="$sections['hero']['cta2']"
        :heroCta2Url="$sections['hero']['cta2_url'] ?? '#projects'"
    />

    {{-- Stats --}}
    <x-sections.stats
        :projectsCount="$sections['stats']['projects_count']"
        :projectsLabel="$sections['stats']['projects_label']"
        :yearsCount="$sections['stats']['years_count']"
        :yearsLabel="$sections['stats']['years_label']"
        :countriesCount="$sections['stats']['countries_count']"
        :countriesLabel="$sections['stats']['countries_label']"
        :clientsCount="$sections['stats']['clients_count']"
        :clientsLabel="$sections['stats']['clients_label']"
    />

    {{-- Services --}}
    <x-sections.services
        :services="$services"
        :eyebrow="$sections['services_section']['eyebrow']"
        :title="$sections['services_section']['title']"
        :subtitle="$sections['services_section']['subtitle']"
    />

    {{-- Process --}}
    <x-sections.process
        :steps="$processSteps"
        :eyebrow="$sections['process_section']['eyebrow']"
        :title="$sections['process_section']['title']"
    />

    {{-- Projects --}}
    <x-sections.projects
        :portfolio="$projects"
        :eyebrow="$sections['projects_section']['eyebrow']"
        :title="$sections['projects_section']['title']"
        :subtitle="$sections['projects_section']['subtitle']"
    />

    {{-- Testimonials --}}
    <x-sections.testimonials
        :testimonials="$testimonials"
        :eyebrow="$sections['testimonials_section']['eyebrow']"
        :title="$sections['testimonials_section']['title']"
    />

    {{-- CTA --}}
    <x-sections.cta
        :title="$sections['cta']['title']"
        :subtitle="$sections['cta']['subtitle']"
        :button="$sections['cta']['button']"
    />

</div>
