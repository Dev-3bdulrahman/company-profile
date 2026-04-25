<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    x-data="{ 
    darkMode: localStorage.getItem('admin_theme') === 'dark' || (!localStorage.getItem('admin_theme') && '{{ $defaultTheme }}' === 'dark') || (!localStorage.getItem('admin_theme') && '{{ $defaultTheme }}' === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('admin_theme', this.darkMode ? 'dark' : 'light');
        if (typeof applyTheme === 'function') applyTheme();
    }
}" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
    <title>{{ $title ?? __('Dashboard') }} - {{ $siteName }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <style>
        body {
            font-family: 'tajawal', 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Tiptap ProseMirror Editor Styles */
        .ProseMirror {
            min-height: 280px;
            padding: 12px 16px;
            outline: none;
            color: inherit;
        }

        .ProseMirror p { margin: 0.5em 0; }
        .ProseMirror h2 { font-size: 1.4em; font-weight: 700; margin: 0.8em 0 0.4em; }
        .ProseMirror h3 { font-size: 1.2em; font-weight: 600; margin: 0.6em 0 0.3em; }
        .ProseMirror ul { list-style: disc; padding-inline-start: 1.5em; margin: 0.5em 0; }
        .ProseMirror ol { list-style: decimal; padding-inline-start: 1.5em; margin: 0.5em 0; }
        .ProseMirror blockquote { border-inline-start: 3px solid #d1d5db; padding-inline-start: 1em; color: #6b7280; margin: 0.5em 0; }
        .ProseMirror a { color: #2563eb; text-decoration: underline; }
        .ProseMirror strong { font-weight: 700; }
        .ProseMirror em { font-style: italic; }
        .ProseMirror s { text-decoration: line-through; }
        .ProseMirror img { max-width: 100%; height: auto; border-radius: 0.5rem; }
        .ProseMirror p.is-editor-empty:first-child::before {
            content: attr(data-placeholder);
            color: #9ca3af;
            pointer-events: none;
            float: inline-start;
            height: 0;
        }

        /* Dark mode */
        .dark .ProseMirror { color: #f3f4f6; }
        .dark .ProseMirror blockquote { border-color: #4b5563; color: #9ca3af; }
        .dark .ProseMirror a { color: #60a5fa; }
    </style>

    <script>
        function applyTheme() {
            const theme = localStorage.getItem('admin_theme');
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
    </script>

    @livewireStyles
    

</head>

<body class="bg-gray-50 dark:bg-gray-950 flex h-screen transition-colors duration-300">
    <!-- Sidebar -->
    <aside
        class="w-64 bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-800 flex-shrink-0 flex flex-col transition-colors duration-300">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
            @if($logoLight || $logoDark)
            <div class="w-10 h-10 flex items-center justify-center">
                @if($logoLight)
                <img src="{{ asset('storage/' . $logoLight) }}" x-show="!darkMode"
                    class="max-w-full max-h-full object-contain" alt="Logo">
                @endif
                @if($logoDark)
                <img src="{{ asset('storage/' . $logoDark) }}" x-show="darkMode"
                    class="max-w-full max-h-full object-contain" alt="Logo">
                @else
                <img src="{{ asset('storage/' . $logoLight) }}" x-show="darkMode"
                    class="max-w-full max-h-full object-contain" alt="Logo">
                @endif
            </div>
            @else
            <div
                class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white font-bold">
                {{ substr($siteName, 0, 2) }}
            </div>
            @endif
            <span class="text-xl font-bold text-gray-900 dark:text-white truncate" title="{{ $siteName }}">{{ $siteName
                }}</span>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @php
                $navLink = fn($route, $icon, $label, $match = null) =>
                    '<a href="' . route($route) . '" wire:navigate class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 ' .
                    (request()->routeIs($match ?? $route) ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800') .
                    '"><i data-lucide="' . $icon . '" class="w-5 h-5 shrink-0"></i><span class="font-medium">' . $label . '</span></a>';
            @endphp

            <div class="pt-2 pb-1">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('Overview') }}</p>
            </div>
            {!! $navLink('admin.dashboard', 'layout-dashboard', __('Dashboard')) !!}

            <div class="pt-5 pb-1">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('Website') }}</p>
            </div>
            {!! $navLink('admin.home_content.hero', 'layout-template', __('Hero Section')) !!}
            {!! $navLink('admin.home_content.stats', 'bar-chart-2', __('Stats Section')) !!}
            {!! $navLink('admin.home_content.cta', 'megaphone', __('CTA Section')) !!}
            {!! $navLink('admin.services', 'briefcase', __('Services')) !!}
            {!! $navLink('admin.portfolio', 'layers', __('Portfolio')) !!}
            {!! $navLink('admin.testimonials', 'message-square-quote', __('Testimonials')) !!}
            {!! $navLink('admin.process_steps', 'list-checks', __('Process Steps')) !!}
            {!! $navLink('admin.blog', 'newspaper', __('Blog'), 'admin.blog*') !!}
            {!! $navLink('admin.pages', 'files', __('Pages'), 'admin.pages*') !!}

            <div class="pt-5 pb-1">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('Inbox') }}</p>
            </div>
            {!! $navLink('admin.leads', 'message-square', __('Messages')) !!}

            <div class="pt-5 pb-1">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('System') }}</p>
            </div>
            {!! $navLink('admin.settings', 'settings', __('Settings')) !!}
            {!! $navLink('admin.visitor_logs', 'users', __('Visitor Logs')) !!}
            @if(\App\Models\LicenseCache::latest()->first()?->show_licensing_ui ?? true)
                {!! $navLink('admin.settings.license', 'shield-check', __('License Activation')) !!}
            @endif

            <div class="border-t border-gray-100 dark:border-gray-800 mt-4 pt-4">
                {!! $navLink('admin.profile', 'user-circle', __('My Profile')) !!}
            </div>
        </nav>

        <div class="p-4 border-t border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3 p-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Manager') }}</p>
                </div>
                <livewire:common.logout-button />
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-h-0">
        <!-- Top Header -->
        <header
            class="h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-8 flex-shrink-0 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">{{ $title ?? __('Home') }}</h2>
            </div>

            <div class="flex items-center gap-4">
                @if($darkModeSupported && $showThemeToggle)
                <button @click="toggleTheme()"
                    class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                    </svg>
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
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
                <livewire:common.notifications />
                <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg transition-colors">
                    <a href="{{ route('lang', ['locale' => 'ar', 'scope' => 'admin']) }}"
                        class="px-3 py-1 text-xs font-bold rounded {{ app()->getLocale() == 'ar' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">عربي</a>
                    <a href="{{ route('lang', ['locale' => 'en', 'scope' => 'admin']) }}"
                        class="px-3 py-1 text-xs font-bold rounded {{ app()->getLocale() == 'en' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">EN</a>
                </div>
                <div class="h-8 w-px bg-gray-200 dark:bg-gray-700"></div>
                <a href="/" target="_blank"
                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                    <span>{{ __('View Site') }}</span>
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <section class="flex-1 p-8 overflow-y-auto min-h-0">
            {{ $slot }}
        </section>
    </main>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Global SweetAlert confirmation listener -->
    <script>
@php
        $swalTrans = [
            'Delete Post'        => __('Delete Post'),
            'Delete Page'        => __('Delete Page'),
            'Delete Service'     => __('Delete Service'),
            'Delete Work'        => __('Delete Work'),
            'Delete Step'        => __('Delete Step'),
            'Delete Testimonial' => __('Delete Testimonial'),
            'Delete Message'     => __('Delete Message'),
            'Clear Logs'         => __('Clear Logs'),
            'Hide Post'          => __('Hide Post'),
            'Publish Post'       => __('Publish Post'),
            'Hide Page'          => __('Hide Page'),
            'Activate Page'      => __('Activate Page'),
            'Are you sure you want to delete this post?'        => __('Are you sure you want to delete this post?'),
            'Are you sure you want to delete this page?'        => __('Are you sure you want to delete this page?'),
            'Are you sure you want to delete this service?'     => __('Are you sure you want to delete this service? This action cannot be undone.'),
            'Are you sure you want to delete this work?'        => __('Are you sure you want to delete this work?'),
            'Are you sure you want to delete this step?'        => __('Are you sure you want to delete this step?'),
            'Are you sure you want to delete this testimonial?' => __('Are you sure you want to delete this testimonial?'),
            'Are you sure you want to delete this message?'     => __('Are you sure you want to delete this message?'),
            'Are you sure you want to clear all visitor logs?'  => __('Are you sure you want to clear all visitor logs?'),
            'Are you sure you want to hide this post?'          => __('Are you sure you want to hide this post?'),
            'Are you sure you want to publish this post?'       => __('Are you sure you want to publish this post?'),
            'Are you sure you want to hide this page?'          => __('Are you sure you want to hide this page?'),
            'Are you sure you want to activate this page?'      => __('Are you sure you want to activate this page?'),
        ];
        @endphp
        const swalTranslations = {!! json_encode($swalTrans) !!};

        window.addEventListener('swal:confirm', event => {
            const data = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            const title = swalTranslations[data.title] || data.title;
            const text  = swalTranslations[data.text]  || data.text;
            const isDelete = data.title && (data.title.toLowerCase().includes('delete') || data.title.includes('حذف') || data.title.includes('تفريغ') || data.title.toLowerCase().includes('clear'));
            
            Swal.fire({
                title: title || "{{ __('Are you sure?') }}",
                text: text || "{{ __('This action cannot be undone.') }}",
                icon: data.icon || 'warning',
                showCancelButton: true,
                confirmButtonText: data.confirmButtonText || "{{ __('Confirm') }}",
                cancelButtonText: data.cancelButtonText || "{{ __('Cancel') }}",
                reverseButtons: true,
                customClass: {
                    container: 'swal-custom-container',
                    popup: 'swal-custom-popup dark:bg-gray-900 dark:text-white rounded-3xl border-none shadow-2xl',
                    title: 'text-2xl font-black text-gray-900 dark:text-white pt-8',
                    htmlContainer: 'text-gray-500 dark:text-gray-400 text-sm font-medium px-8 pb-4',
                    confirmButton: `px-8 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg ${isDelete ? 'bg-red-600 hover:bg-red-700 shadow-red-600/20' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20'} text-white border-none mx-2`,
                    cancelButton: 'px-8 py-3 rounded-2xl font-bold text-sm bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all border-none mx-2',
                    actions: 'pb-8 pt-4'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'animate__animated animate__fadeInUp animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutDown animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(data.onConfirm, data.params || {});
                }
            });
        });

        // Handle standard notifications with SweetAlert Toast
        window.addEventListener('notify', event => {
            const data = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: data.type || 'success',
                title: data.message
            });
        });
    </script>

    <script>
        function scrollSidebarToActive() {
            const activeLink = document.querySelector('aside nav a.bg-blue-600');
            if (activeLink) {
                activeLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function initIcons() {
            if (typeof window.initLucide === 'function') {
                window.initLucide();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            scrollSidebarToActive();
            initIcons();
        });

        document.addEventListener('livewire:navigated', () => {
            scrollSidebarToActive();
            initIcons();
        });

        document.addEventListener('livewire:init', () => {
            Livewire.hook('request', ({ succeed }) => {
                succeed(() => {
                    setTimeout(initIcons, 50);
                });
            });
        });
    </script>


    @stack('scripts')
</body>

</html>