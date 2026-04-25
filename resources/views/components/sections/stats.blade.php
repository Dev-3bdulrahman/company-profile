@props(['projectsCount', 'projectsLabel', 'yearsCount', 'yearsLabel', 'countriesCount', 'countriesLabel', 'clientsCount', 'clientsLabel'])

<section class="relative -mt-16 z-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="surface-card rounded-2xl p-8 sm:p-10 grid grid-cols-2 md:grid-cols-4 gap-8 backdrop-blur-xl">
            <div class="text-center">
                <div class="text-4xl sm:text-5xl font-black gradient-text mb-2">{{ $projectsCount }}</div>
                <div class="text-sm text-muted-foreground font-medium">{{ $projectsLabel }}</div>
            </div>
            <div class="text-center">
                <div class="text-4xl sm:text-5xl font-black gradient-text mb-2">{{ $yearsCount }}</div>
                <div class="text-sm text-muted-foreground font-medium">{{ $yearsLabel }}</div>
            </div>
            <div class="text-center">
                <div class="text-4xl sm:text-5xl font-black gradient-text mb-2">{{ $countriesCount }}</div>
                <div class="text-sm text-muted-foreground font-medium">{{ $countriesLabel }}</div>
            </div>
            <div class="text-center">
                <div class="text-4xl sm:text-5xl font-black gradient-text mb-2">{{ $clientsCount }}</div>
                <div class="text-sm text-muted-foreground font-medium">{{ $clientsLabel }}</div>
            </div>
        </div>
    </div>
</section>
