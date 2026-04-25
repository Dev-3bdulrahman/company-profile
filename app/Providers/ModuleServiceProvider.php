<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $modulesDirectory = app_path('Modules');

        if (File::exists($modulesDirectory)) {
            $modules = array_map('basename', File::directories($modulesDirectory));

            foreach ($modules as $module) {
                $providerClass = "App\\Modules\\{$module}\\Providers\\{$module}ServiceProvider";

                if (class_exists($providerClass)) {
                    $this->app->register($providerClass);
                }
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
