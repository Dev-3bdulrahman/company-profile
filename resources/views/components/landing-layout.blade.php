<div class="landing-page-body min-h-screen flex flex-col font-latin rtl:font-arabic transition-all duration-500"
     x-data="{
        scrolled: false,
        mobileMenu: false
     }"
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     class="selection:bg-primary selection:text-primary-foreground"
>
    @php
        $siteSettings = app(\App\Services\SettingService::class)->getSettings();
        $localizedSettings = app(\App\Services\SettingService::class)->getLocalizedSettings();
        $siteName = $localizedSettings['site_name'] ?? config('app.name');
        $siteTagline = $localizedSettings['job_title'] ?? __('landing.brand_tagline');
        $logoLight = $siteSettings['logo_light'] ?? null;
    @endphp

    <!-- Header -->
    <header :class="scrolled ? 'bg-background/80 backdrop-blur-xl border-b border-border py-3 shadow-lg' : 'bg-transparent py-5'"
            class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer">
                    @if(isset($logoLight) && $logoLight)
                        <img src="{{ asset('storage/' . $logoLight) }}" alt="{{ $siteName }}" class="h-10 object-contain group-hover:scale-105 transition-transform">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center glow-primary transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                        </div>
                        <span class="text-xl font-black tracking-tight leading-none">{{ $siteName }}</span>
                    @endif
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-primary' : 'text-muted-foreground' }} px-5 py-2 rounded-full text-sm font-bold hover:text-primary transition-colors">{{ __('landing.nav.home') }}</a>
                    <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'text-primary' : 'text-muted-foreground' }} px-5 py-2 rounded-full text-sm font-bold hover:text-primary transition-colors">{{ __('landing.nav.services') }}</a>
                    <a href="{{ url('/projects') }}" class="{{ request()->is('projects*') ? 'text-primary' : 'text-muted-foreground' }} px-5 py-2 rounded-full text-sm font-bold hover:text-primary transition-colors">{{ __('landing.nav.projects') }}</a>
                    <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'text-primary' : 'text-muted-foreground' }} px-5 py-2 rounded-full text-sm font-bold hover:text-primary transition-colors">{{ __('landing.nav.contact') }}</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <!-- Lang Switcher -->
                    @if(app()->getLocale() == 'ar')
                        <a href="{{ route('lang', ['locale' => 'en', 'scope' => 'frontend']) }}" class="hidden md:flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-muted-foreground hover:text-foreground hover:bg-secondary transition-colors" aria-label="Toggle language">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                            EN
                        </a>
                    @else
                        <a href="{{ route('lang', ['locale' => 'ar', 'scope' => 'frontend']) }}" class="hidden md:flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-muted-foreground hover:text-foreground hover:bg-secondary transition-colors" aria-label="Toggle language">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                            ع
                        </a>
                    @endif

                    <a href="{{ url('/contact') }}" class="hidden md:flex bg-primary text-primary-foreground px-6 py-2.5 rounded-full text-sm font-black glow-primary hover:scale-105 active:scale-95 transition-all">
                        {{ __('landing.nav.quote') }}
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-foreground">
                        <svg x-show="!mobileMenu" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                        <svg x-show="mobileMenu" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden absolute top-full left-0 right-0 bg-background/95 backdrop-blur-2xl border-b border-border p-6 shadow-2xl">
            <div class="flex flex-col gap-4">
                <a href="{{ url('/') }}" @click="mobileMenu = false" class="text-xl font-bold p-2">{{ __('landing.nav.home') }}</a>
                <a href="{{ route('services.index') }}" @click="mobileMenu = false" class="text-xl font-bold p-2">{{ __('landing.nav.services') }}</a>
                <a href="{{ url('/projects') }}" @click="mobileMenu = false" class="text-xl font-bold p-2">{{ __('landing.nav.projects') }}</a>
                <a href="{{ url('/contact') }}" @click="mobileMenu = false" class="text-xl font-bold p-2">{{ __('landing.nav.contact') }}</a>
                <hr class="border-border">
                <div class="flex justify-between items-center">
                    @if(app()->getLocale() == 'ar')
                        <a href="{{ route('lang', ['locale' => 'en', 'scope' => 'frontend']) }}" class="text-sm font-bold uppercase tracking-widest">Switch to EN</a>
                    @else
                        <a href="{{ route('lang', ['locale' => 'ar', 'scope' => 'frontend']) }}" class="text-sm font-bold uppercase tracking-widest">تحويل للعربية</a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="py-12 px-4 sm:px-6 lg:px-8 border-t border-border">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-3">
                @if(isset($logoLight) && $logoLight)
                    <img src="{{ asset('storage/' . $logoLight) }}" alt="{{ $siteName }}" class="h-8 object-contain">
                @else
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 16.326A7 7 0 1 1 18 16.326V18a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2z"/><path d="M10 10V8a2 2 0 1 1 4 0v2"/><path d="M16 10H8"/></svg>
                    </div>
                    <span class="text-lg font-black tracking-tighter uppercase">{{ $siteName }}</span>
                @endif
            </div>
            <p class="text-sm text-muted-foreground font-bold">
                © {{ date('Y') }} {{ $siteName }}. {{ __('landing.footer.rights') }}.
            </p>
            <div class="flex gap-6">
                @foreach(['facebook', 'instagram', 'linkedin', 'twitter', 'tiktok', 'youtube'] as $social)
                    @if($url = \App\Models\SiteSetting::getValue($social))
                    <a href="{{ $url }}" target="_blank" class="text-muted-foreground hover:text-primary transition-colors">
                        <i data-lucide="{{ $social == 'facebook' ? 'facebook' : ($social == 'instagram' ? 'instagram' : ($social == 'linkedin' ? 'linkedin' : ($social == 'twitter' ? 'twitter' : ($social == 'tiktok' ? 'music' : 'youtube')))) }}" class="w-5 h-5"></i>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('livewire:init', () => {
            if (window.initLucide) window.initLucide();
        });
        document.addEventListener('livewire:navigated', () => {
            if (window.initLucide) window.initLucide();
        });
    </script>
</div>
