<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InstallerService
{
    /**
     * Check if the application is already installed.
     */
    public function isInstalled(): bool
    {
        return File::exists(storage_path('installed'));
    }

    /**
     * Mark the application as installed.
     */
    public function markAsInstalled(): bool
    {
        File::put(storage_path('installed'), date('Y-m-d H:i:s'));
        $this->cleanupInstaller();
        return true;
    }

    /**
     * Delete installer files and remove routes.
     */
    public function cleanupInstaller(): void
    {
        // Don't delete files if we are in local environment
        if (config('app.env') === 'local') {
            return;
        }

        // 1. Delete the Livewire Component
        $componentPath = app_path('Http/Controllers/Web/Installer.php');
        if (File::exists($componentPath)) {
            File::delete($componentPath);
        }

        // 2. Delete the Blade View
        $viewPath = resource_path('views/livewire/installer.blade.php');
        if (File::exists($viewPath)) {
            File::delete($viewPath);
        }

        // 3. Remove Route from web.php
        $webRoutesPath = base_path('routes/web.php');
        if (File::exists($webRoutesPath)) {
            $content = File::get($webRoutesPath);
            // Match the installer route line precisely
            $content = preg_replace('/Route::get\(\'\/install\',.*installer::class\)->name\(\'install\'\);/i', '', $content);
            // Clean up double newlines
            $content = preg_replace("/\n\n+/", "\n\n", $content);
            File::put($webRoutesPath, trim($content) . "\n");
        }
        
        // 4. Clear cache to reflect changes
        try {
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
        } catch (\Exception $e) {}
    }

    /**
     * Check system requirements.
     */
    public function checkRequirements(): array
    {
        $requirements = [
            'php_version' => [
                'name' => 'PHP Version >= 8.2',
                'passed' => version_compare(PHP_VERSION, '8.2.0', '>='),
                'current' => PHP_VERSION,
            ],
            'ext_openssl' => ['name' => 'OpenSSL Extension', 'passed' => extension_loaded('openssl')],
            'ext_pdo' => ['name' => 'PDO Extension', 'passed' => extension_loaded('pdo')],
            'ext_mbstring' => ['name' => 'Mbstring Extension', 'passed' => extension_loaded('mbstring')],
            'ext_tokenizer' => ['name' => 'Tokenizer Extension', 'passed' => extension_loaded('tokenizer')],
            'ext_xml' => ['name' => 'XML Extension', 'passed' => extension_loaded('xml')],
            'ext_ctype' => ['name' => 'CType Extension', 'passed' => extension_loaded('ctype')],
            'ext_json' => ['name' => 'JSON Extension', 'passed' => extension_loaded('json')],
            'ext_bcmath' => ['name' => 'BCMath Extension', 'passed' => extension_loaded('bcmath')],
            'ext_curl' => ['name' => 'CURL Extension', 'passed' => extension_loaded('curl')],
        ];

        $allPassed = true;
        foreach ($requirements as $req) {
            if (!$req['passed']) $allPassed = false;
        }

        return [
            'requirements' => $requirements,
            'all_passed' => $allPassed,
        ];
    }

    /**
     * Check folder permissions.
     */
    public function checkPermissions(): array
    {
        $paths = [
            'storage' => storage_path(),
            'bootstrap_cache' => base_path('bootstrap/cache'),
            'env' => base_path('.env'),

        ];

        $permissions = [];
        $allPassed = true;

        foreach ($paths as $key => $path) {
            $exists = File::exists($path);
            $isWritable = $exists && File::isWritable($path);
            
            $passed = $isWritable;
            $note = null;

            // Special handling for .env in Docker/Coolify
            if ($key === 'env') {
                // If APP_KEY is already set in the environment, we don't strictly need the .env file
                if (env('APP_KEY') && env('APP_KEY') !== 'base64:...') {
                    $passed = true;
                    $note = __('Handled by System');
                }
            }

            $permissions[$key] = [
                'name' => $key,
                'path' => $path,
                'passed' => $passed,
                'note' => $note,
            ];

            if (!$passed && $key !== 'env') {
                $allPassed = false;
            }
        }

        return [
            'permissions' => $permissions,
            'all_passed' => $allPassed,
        ];
    }

    /**
     * Test database connection.
     */
    public function testDbConnection(array $config): array
    {
        try {
            config([
                'database.connections.install_test' => [
                    'driver' => 'mysql',
                    'host' => $config['host'],
                    'port' => $config['port'],
                    'database' => $config['database'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                    'options' => [
                        \PDO::ATTR_TIMEOUT => 5,
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    ],
                ]
            ]);

            DB::purge('install_test');
            DB::connection('install_test')->getPdo();
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Update .env file with database configuration.
     */
    public function updateEnv(array $config): bool
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            File::copy(base_path('.env.example'), $envPath);
        }

        $envContent = File::get($envPath);

        $replacements = [
            'DB_HOST' => $config['host'],
            'DB_PORT' => $config['port'],
            'DB_DATABASE' => $config['database'],
            'DB_USERNAME' => $config['username'],
            'DB_PASSWORD' => $config['password'],
            'APP_URL' => url('/'),
        ];

        foreach ($replacements as $key => $value) {
            if (preg_match("/^{$key}=/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $envContent);
            } else {
                $envContent .= "\n{$key}=\"{$value}\"";
            }
        }

        return File::put($envPath, $envContent) !== false;
    }
}
