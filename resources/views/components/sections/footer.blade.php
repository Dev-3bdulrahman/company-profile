@props(['siteName', 'logoLight', 'footerAbout', 'contactEmail', 'contactPhone', 'address'])

<footer class="border-t border-border bg-surface/50 mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-3 mb-6 group cursor-pointer">
                    @if(isset($logoLight) && $logoLight)
                        <img src="{{ asset('storage/' . $logoLight) }}" alt="{{ $siteName }}" class="h-10 object-contain group-hover:scale-105 transition-transform">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center glow-primary transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                        </div>
                        <span class="text-xl font-black tracking-tight leading-none uppercase">{{ $siteName }}</span>
                    @endif
                </a>
                <p class="text-muted-foreground max-w-md mb-8 leading-relaxed font-medium">{{ $footerAbout }}</p>
                <div class="flex items-center gap-3">
                    @foreach(['instagram', 'twitter', 'linkedin', 'facebook', 'tiktok', 'youtube'] as $social)
                        @if($url = \App\Models\SiteSetting::getValue($social))
                        <a href="{{ $url }}" target="_blank"
                           class="w-10 h-10 rounded-lg bg-secondary hover:bg-primary hover:text-primary-foreground transition-all duration-300 flex items-center justify-center group/social"
                           aria-label="{{ ucfirst($social) }}">
                            <i data-lucide="{{ $social == 'tiktok' ? 'music' : ($social == 'twitter' ? 'twitter' : $social) }}" class="w-5 h-5 group-hover/social:scale-110 transition-transform"></i>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider mb-6 text-foreground">
                    {{ __('landing.footer.quickLinks') }}
                </h3>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('home') }}" wire:navigate class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/20 group-hover:bg-primary transition-colors"></span>
                            {{ __('landing.nav.home') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.index') }}" wire:navigate class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/20 group-hover:bg-primary transition-colors"></span>
                            {{ __('landing.nav.services') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('projects.index') }}" wire:navigate class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/20 group-hover:bg-primary transition-colors"></span>
                            {{ __('landing.nav.projects') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blog.index') }}" wire:navigate class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/20 group-hover:bg-primary transition-colors"></span>
                            {{ __('landing.nav.blog') }}
                        </a>
                    </li>
                    @foreach(\App\Models\Page::where('is_active', true)->orderBy('sort_order')->get() as $p)
                    <li>
                        <a href="{{ route('pages.show', $p->slug) }}" wire:navigate class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/20 group-hover:bg-primary transition-colors"></span>
                            {{ $p->getTranslation('title') }}
                        </a>
                    </li>
                    @endforeach
                    <li>
                        <a href="{{ route('contact') }}" wire:navigate class="text-sm font-bold text-muted-foreground hover:text-primary transition-colors flex items-center gap-2 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/20 group-hover:bg-primary transition-colors"></span>
                            {{ __('landing.nav.contact') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider mb-6 text-foreground">
                    {{ __('landing.footer.contactUs') }}
                </h3>
                <ul class="space-y-4">
                    @if($address)
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <i data-lucide="map-pin" class="w-4 h-4 text-primary"></i>
                        </div>
                        <span class="text-sm font-bold text-muted-foreground leading-relaxed">{{ $address }}</span>
                    </li>
                    @endif
                    @if($contactPhone)
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <i data-lucide="phone" class="w-4 h-4 text-primary"></i>
                        </div>
                        <span class="text-sm font-bold text-muted-foreground" dir="ltr">{{ $contactPhone }}</span>
                    </li>
                    @endif
                    @if($contactEmail)
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <i data-lucide="mail" class="w-4 h-4 text-primary"></i>
                        </div>
                        <span class="text-sm font-bold text-muted-foreground">{{ $contactEmail }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="mt-16 pt-8 border-t border-border" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            {{-- Row 1: Copyright + Legal Links --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-4">
                <p class="text-xs text-muted-foreground font-medium">
                    &copy; {{ date('Y') }} <span class="font-bold text-foreground/80">{{ $siteName }}</span>. {{ __('landing.footer.rights') }}.
                </p>
                <div class="flex items-center gap-2">
                    <a href="{{ route('legal.privacy') }}" wire:navigate
                       class="text-xs font-semibold text-muted-foreground hover:text-primary transition-colors px-3 py-1 rounded-full hover:bg-primary/10">
                        {{ __('landing.contact.privacy_policy') }}
                    </a>
                    <span class="text-border text-xs select-none">|</span>
                    <a href="{{ route('legal.terms') }}" wire:navigate
                       class="text-xs font-semibold text-muted-foreground hover:text-primary transition-colors px-3 py-1 rounded-full hover:bg-primary/10">
                        {{ __('landing.contact.terms_of_service') }}
                    </a>
                </div>
            </div>

            {{-- Row 2: Developer Credit --}}
            <div class="flex justify-center sm:justify-start">
                <span class="inline-flex items-center gap-1.5 text-[11px] text-muted-foreground/60 font-medium tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-primary/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    {{ __('landing.contact.developed_by') }}
                    <a href="https://3bdulrahman.com" target="_blank" rel="noopener noreferrer"
                       class="font-bold text-foreground/70 hover:text-primary transition-colors underline decoration-primary/30 underline-offset-2">
                        {{ __('landing.contact.designer_name') }}
                    </a>
                </span>
            </div>
        </div>
    </div>
</footer>
