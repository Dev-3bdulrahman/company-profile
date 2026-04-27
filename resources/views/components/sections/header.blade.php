@props(['siteName', 'logoLight', 'logoDark' => null, 'scrolled' => false])

<header x-data="{ 
            mobileMenu: false, 
            scrolled: window.pageYOffset > 50,
            isHome: @json(request()->routeIs('home'))
        }"
        @scroll.window="scrolled = (window.pageYOffset > 50)"
        :class="(scrolled || !isHome) ? 'bg-background/95 backdrop-blur-xl border-b border-border py-3 shadow-lg' : 'bg-transparent py-5'"
        class="fixed top-0 left-0 right-0 z-[100] transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 group cursor-pointer">
                @if(isset($logoLight) && $logoLight)
                    <img src="{{ asset('storage/' . $logoLight) }}" alt="{{ $siteName }}" class="h-10 object-contain group-hover:scale-105 transition-transform {{ $logoDark ? 'dark:hidden' : '' }}">
                    @if($logoDark)
                        <img src="{{ asset('storage/' . $logoDark) }}" alt="{{ $siteName }}" class="h-10 object-contain group-hover:scale-105 transition-transform hidden dark:block">
                    @endif
                @else
                    <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center glow-primary transition-transform group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                    </div>
                    <span class="text-xl font-black tracking-tight leading-none">{{ $siteName }}</span>
                @endif
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center gap-1">
                @php
                    $navColor = '#b0d742';
                    $links = [
                        ['route' => 'home', 'label' => __('landing.nav.home'), 'active' => request()->routeIs('home')],
                        ['route' => 'pages.show', 'params' => ['slug' => 'about-us'], 'label' => __('landing.nav.about'), 'active' => request()->fullUrlIs(route('pages.show', 'about-us'))],
                        ['route' => 'services.index', 'label' => __('landing.nav.services'), 'active' => request()->routeIs('services.*')],
                        ['route' => 'projects.index', 'label' => __('landing.nav.projects'), 'active' => request()->routeIs('projects.*')],
                        ['route' => 'blog.index', 'label' => __('landing.nav.blog'), 'active' => request()->routeIs('blog.*')],
                        ['route' => 'contact', 'label' => __('landing.nav.contact'), 'active' => request()->routeIs('contact')],
                    ];
                @endphp

                @foreach($links as $link)
                <a href="{{ route($link['route'], $link['params'] ?? []) }}" 
                   wire:navigate 
                   class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ $link['active'] ? 'bg-primary text-primary-foreground shadow-lg scale-105 glow-primary' : 'hover:bg-primary/10' }}"
                   style="{{ !$link['active'] ? 'color: ' . $navColor : '' }}">
                    {{ $link['label'] }}
                </a>
                @endforeach
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

                <a href="{{ route('contact') }}" wire:navigate class="hidden md:flex bg-primary text-primary-foreground px-6 py-2.5 rounded-full text-sm font-black glow-primary hover:scale-105 active:scale-95 transition-all">
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
            @foreach($links as $link)
            <a href="{{ route($link['route'], $link['params'] ?? []) }}" 
               wire:navigate 
               @click="mobileMenu = false" 
               class="text-xl font-bold p-3 rounded-xl transition-colors {{ $link['active'] ? 'bg-primary/10 text-primary' : '' }}"
               style="{{ !$link['active'] ? 'color: ' . $navColor : '' }}">
                {{ $link['label'] }}
            </a>
            @endforeach
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
