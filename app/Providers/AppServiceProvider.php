<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        config(['livewire.class_namespace' => 'App\\Http\\Controllers\\Web']);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layouts.guest', 'guest-layout');
        Livewire::addLocation(null, 'App\\Http\\Controllers\\Web');
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        if (env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\TicketCreated::class,
            \App\Listeners\SendWebhookNotification::class,
        );
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\TicketCreated::class,
            \App\Listeners\SendDatabaseNotification::class,
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\TicketReplied::class,
            \App\Listeners\SendWebhookNotification::class,
        );
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\TicketReplied::class,
            \App\Listeners\SendDatabaseNotification::class,
        );

        \Illuminate\Support\Facades\Event::listen(
            \App\Events\TodoAssigned::class,
            \App\Listeners\SendWebhookNotification::class,
        );
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\TodoAssigned::class,
            \App\Listeners\SendDatabaseNotification::class,
        );

        // Share branding settings globally
        view()->composer('*', function ($view) {
            $isInstalled = \Illuminate\Support\Facades\File::exists(storage_path('installed'));
            
            if (!$isInstalled) {
                $view->with([
                    'siteSettings' => [],
                    'localizedSettings' => [],
                    'logoLight' => null,
                    'logoDark' => null,
                    'siteName' => config('app.name'),
                    'favicon' => 'favicon.ico',
                    'defaultTheme' => 'dark',
                    'showThemeToggle' => true,
                    'darkModeSupported' => true,
                ]);
                return;
            }

            $settingsService = app(\App\Services\SettingService::class);
            $siteSettings = $settingsService->getSettings();



            // Build localized settings
            $locale = app()->getLocale();
            $fallback = config('app.fallback_locale', 'en');
            $localizedSettings = [];
            foreach ($siteSettings as $key => $value) {
                if (is_array($value)) {
                    $localizedSettings[$key] = $value[$locale] ?? $value[$fallback] ?? reset($value);
                } else {
                    $localizedSettings[$key] = $value;
                }
            }

            $view->with([
                'siteSettings' => $siteSettings,
                'localizedSettings' => $localizedSettings,
                'logoLight' => $siteSettings['logo_light'] ?? null,
                'logoDark' => $siteSettings['logo_dark'] ?? null,
                'siteName' => $localizedSettings['site_name'] ?? config('app.name'),
                'favicon' => $siteSettings['favicon'] ?? 'favicon.ico',
                'defaultTheme' => $siteSettings['default_theme'] ?? 'dark',
                'showThemeToggle' => $siteSettings['show_theme_toggle'] ?? true,
                'darkModeSupported' => $siteSettings['dark_mode_supported'] ?? true,
            ]);
        });
    }
}