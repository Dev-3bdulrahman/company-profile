<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    x-data="{ 
    darkMode: localStorage.getItem('frontend_theme') === 'dark' || (!localStorage.getItem('frontend_theme') && '{{ $defaultTheme }}' === 'dark') || (!localStorage.getItem('frontend_theme') && '{{ $defaultTheme }}' === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('frontend_theme', this.darkMode ? 'dark' : 'light');
        if (typeof applyTheme === 'function') applyTheme();
    }
}" :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">

    <!-- Preload Critical Fonts -->
    <link rel="preload" href="{{ asset('fonts/Tajawal/Tajawal-Regular-ar.woff2') }}" as="font" type="font/woff2"
        crossorigin>
    <link rel="preload" href="{{ asset('fonts/Tajawal/Tajawal-Regular-latin.woff2') }}" as="font" type="font/woff2"
        crossorigin>

    <title>{{ $siteName }}</title>
    @if(!empty($localizedSettings['seo_description']))
    <meta name="description" content="{{ $localizedSettings['seo_description'] }}">
    @endif
    @if(!empty($localizedSettings['seo_keywords']))
    <meta name="keywords" content="{{ $localizedSettings['seo_keywords'] }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $localizedSettings['seo_title'] ?? config('app.name', 'Laravel') }}">
    @if(!empty($localizedSettings['seo_description']))
    <meta property="og:description" content="{{ $localizedSettings['seo_description'] }}">
    @endif
    @if(!empty($siteSettings['logo_light']))
    <meta property="og:image" content="{{ asset('storage/' . $siteSettings['logo_light']) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $localizedSettings['seo_title'] ?? config('app.name', 'Laravel') }}">
    @if(!empty($localizedSettings['seo_description']))
    <meta property="twitter:description" content="{{ $localizedSettings['seo_description'] }}">
    @endif
    @if(!empty($siteSettings['logo_light']))
    <meta property="twitter:image" content="{{ asset('storage/' . $siteSettings['logo_light']) }}">
    @endif

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "{{ '@' }}context": "https://schema.org",
      "{{ '@' }}type": "Person",
      "name": "{{ $localizedSettings['site_name'] ?? 'Abdulrahman Mohsen' }}",
      "url": "{{ config('app.url') }}",
      "jobTitle": "{{ $localizedSettings['job_title'] ?? 'Software Developer' }}",
      "description": "{{ $localizedSettings['site_description'] ?? '' }}",
      "sameAs": [
        @php
            $socials = array_filter([
                $siteSettings['facebook'] ?? '',
                $siteSettings['twitter'] ?? '',
                $siteSettings['instagram'] ?? '',
                $siteSettings['linkedin'] ?? ''
            ]);
            echo implode(",\n        ", array_map(fn($s) => '"'.$s.'"', $socials));
        @endphp
      ]
    }
    </script>

    <!-- Tracking Scripts -->
    @if (!empty($siteSettings['google_analytics_id']))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', '{{ $siteSettings['google_analytics_id'] }}');
    </script>
    @endif

    @if (!empty($siteSettings['google_tag_manager_id']))
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ $siteSettings['google_tag_manager_id'] }}');</script>
    <!-- End Google Tag Manager -->
    @endif

    @if (!empty($siteSettings['facebook_pixel_id']))
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
            n.queue = []; t = b.createElement(e); t.async = !0;
            t.src = v; s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $siteSettings['facebook_pixel_id'] }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ $siteSettings['facebook_pixel_id'] }}&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->
    @endif

    @if(!empty($siteSettings['custom_header_scripts']))
    <!-- Custom Header Scripts -->
    {!! $siteSettings['custom_header_scripts'] !!}
    @endif

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/landing.css'])

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .tab-content {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function applyTheme() {
            const theme = localStorage.getItem('frontend_theme');
            const defaultTheme = '{{ $defaultTheme }}';
            const isDark = theme === 'dark' || (!theme && defaultTheme === 'dark') || (!theme && defaultTheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        // Apply theme immediately
        applyTheme();

        // Re-apply on Livewire navigation
        document.addEventListener('livewire:navigated', applyTheme);

        // Re-initialize Lucide icons on Livewire updates
        document.addEventListener('livewire:init', () => {
            Livewire.hook('request', ({ component, request, respond, succeed, fail }) => {
                succeed(({ response }) => {
                    queueMicrotask(() => {
                        if (window.initLucide) window.initLucide();
                    });
                });
            });
        });
    </script>

    @livewireStyles
</head>

<body
    class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 overflow-x-hidden transition-colors duration-300 landing-page-body">
    @if (!empty($siteSettings['google_tag_manager_id']))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $siteSettings['google_tag_manager_id'] }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    @if(!empty($siteSettings['custom_body_scripts']))
    <!-- Custom Body Scripts -->
    {!! $siteSettings['custom_body_scripts'] !!}
    @endif

    @if($darkModeSupported && $showThemeToggle)
    <button @click="toggleTheme()" aria-label="{{ __('Toggle Theme') }}"
        class="fixed bottom-8 right-8 z-40 p-4 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-full shadow-lg border border-gray-100 dark:border-gray-700 hover:scale-110 transition-all duration-300">
        <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
        </svg>
        <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
            <circle cx="12" cy="12" r="4" />
            <path d="M12 2v2" />
            <path d="M12 20v2" />
            <path d="m4.93 4.93 1.41 1.41" />
            <path d="m17.66 17.66 1.41 1.41" />
            <path d="M2 12h2" />
            <path d="M20 12h2" />
            <path d="m6.34 17.66-1.41 1.41" />
            <path d="m19.07 4.93-1.41 1.41" />
        </svg>
    </button>
    @endif

    <x-sections.header :siteName="$siteName" :logoLight="$logoLight" />

    <main class="min-h-screen {{ !request()->routeIs('home') ? 'pt-24' : '' }}">
        {{ $slot }}
    </main>

    @php
        $footerAbout = \App\Models\SiteSetting::getValue('footer_about') ?? \App\Models\SiteSetting::getValue('site_description') ?? '';
        $contactEmail = \App\Models\SiteSetting::getValue('contact_email');
        $contactPhone = \App\Models\SiteSetting::getValue('contact_phone');
        $address = \App\Models\SiteSetting::getValue('address');
    @endphp

    <x-sections.footer 
        :siteName="$siteName" 
        :logoLight="$logoLight" 
        :footerAbout="$footerAbout"
        :contactEmail="$contactEmail"
        :contactPhone="$contactPhone"
        :address="$address"
    />

    @if(!empty($siteSettings['custom_footer_scripts']))
    <!-- Custom Footer Scripts -->
    {!! $siteSettings['custom_footer_scripts'] !!}
    @endif

    @livewireScripts
    @stack('scripts')
</body>

</html>