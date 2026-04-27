<?php

namespace App\Http\Controllers\Web;

use Livewire\Attributes\On;
use App\Services\InstallerService;
use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Installer extends Component
{
    public $step = 1; // 1: Requirements, 2: License, 3: Database, 4: Finish
    
    // Requirements Step
    public $requirements = [];
    public $permissions = [];
    public $canContinueRequirements = false;

    // License Step
    public $license_key = '';
    public $product_code = 'PRFL-001'; // Default
    public $licenseError = '';

    // Database Step
    public $dbConfig = [
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => '',
        'username' => 'root',
        'password' => '',
    ];
    public $dbError = '';
    public $installProgress = 0;
    public $installStatus = '';
    public $isInstalling = false;
    public $showDbPrompt = false;
    public $hasExistingTables = false;

    // Admin Step
    public $adminConfig = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];
    public $adminError = '';
    public $skipAdminUpdate = false;

    protected $installerService;

    public function setLocale($lang)
    {
        if (in_array($lang, ['ar', 'en'])) {
            session(['locale' => $lang]);
            app()->setLocale($lang);
        }
        $this->checkRequirements(); // Refresh requirements text if needed
    }

    public function boot(InstallerService $installerService)
    {
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
        $this->installerService = $installerService;
    }

    public function mount()
    {
        if (app(InstallerService::class)->isInstalled()) {
            return redirect()->route('home');
        }
        $this->checkRequirements();
    }

    public function checkRequirements()
    {
        $reqs = $this->installerService->checkRequirements();
        $perms = $this->installerService->checkPermissions();
        
        $this->requirements = $reqs['requirements'];
        $this->permissions = $perms['permissions'];
        
        $this->canContinueRequirements = $reqs['all_passed'] && $perms['all_passed'];
    }

    public function nextStep()
    {
        if ($this->step == 1 && $this->canContinueRequirements) {
            $this->step = 2;
        } elseif ($this->step == 2) {
            $this->activateLicense();
        } elseif ($this->step == 3) {
            $this->setupDatabase();
        } elseif ($this->step == 4) {
            $this->createAdminAccount();
        }
    }

    public function createAdminAccount()
    {
        $this->validate([
            'adminConfig.name' => 'required|string|max:255',
            'adminConfig.email' => 'required|email|max:255',
            'adminConfig.password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = \App\Models\User::updateOrCreate(
                ['email' => $this->adminConfig['email']],
                [
                    'name' => $this->adminConfig['name'],
                    'password' => \Illuminate\Support\Facades\Hash::make($this->adminConfig['password']),
                ]
            );

            // Assign Admin Role if Spatie is used
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('admin');
            }

            $this->installerService->markAsInstalled();
            $this->step = 5;
        } catch (\Exception $e) {
            $this->adminError = __('Failed to create account: ') . $e->getMessage();
        }
    }


    public function activateLicense()
    {
        $this->validate([
            'license_key' => 'required|string',
            'product_code' => 'required|string',
        ]);
        $this->licenseError = '';
        
        // Verify license directly via HTTP without touching the database
        try {
            $url = config('license.server_url') . '/api/license/authorize';
            $payload = [
                'license_key'        => $this->license_key,
                'product_code'       => $this->product_code,
                'domain'             => request()->getHost(),

                'ip_address'         => request()->ip(),
                'machine_fingerprint' => md5(php_uname()),
                'timestamp'          => now()->timestamp,
                'nonce'              => bin2hex(random_bytes(16)),
            ];

            Log::info('[Installer] Verifying license (Discovery Mode): ' . $this->license_key);
            $response = Http::timeout(15)->post($url, $payload);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Verify signature
                if ($this->verifyResponseSignature($data)) {
                    // 1. Store in session
                    session(['installer_license_key' => $this->license_key]);
                    session(['installer_license_data' => $data]);
                    session(['installer_product_code' => $this->product_code]);

                    // 2. Persist to .env IMMEDIATELY (if possible)
                    $this->installerService->updateEnv([
                        'LICENSE_PRODUCT_CODE' => $this->product_code,
                        'LICENSE_KEY' => $this->license_key,
                    ]);

                    // 3. Fetch Deployment Files (Migrations/Seeders)
                    if (!$this->fetchDeploymentFiles($payload)) {
                        return; // Error message already set in fetchDeploymentFiles
                    }

                    // 3. Fetch Deployment Files (Migrations/Seeders)
                    if (!$this->fetchDeploymentFiles($payload)) {
                        return; // Error message already set in fetchDeploymentFiles
                    }

                    $this->step = 3;
                    return;
                }

                // Signature failed - try fetching fresh public key from server
                $keyResponse = Http::timeout(5)->get(config('license.server_url') . '/api/license/public-key');
                if ($keyResponse->successful() && isset($keyResponse->json()['public_key'])) {
                    $freshKey = $keyResponse->json()['public_key'];
                    if ($this->verifyResponseSignature($data, $freshKey)) {
                        \Illuminate\Support\Facades\Cache::forever('license_public_key', $freshKey);
                        session(['installer_license_key' => $this->license_key]);
                        session(['installer_license_data' => $data]);
                        session(['installer_product_code' => $data['product_code'] ?? '']);

                        // Fetch Deployment Files
                        if (!$this->fetchDeploymentFiles($payload)) {
                            return;
                        }

                        $this->step = 3;
                        return;
                    }
                }
                
                $this->licenseError = __('Security Verification Failed. Invalid response signature.');
                return;
            }
            $this->licenseError = $response->json('error.message') ?? __('License not valid.');
        } catch (\Exception $e) {
            Log::error('[Installer] Activation failed: ' . $e->getMessage());
            $this->licenseError = __('Activation error: ') . $e->getMessage();
        }
    }

    protected function fetchDeploymentFiles(array $payload): bool
    {
        try {
            $url = config('license.server_url') . '/api/license/deployment-files';
            Log::info('[Installer] Fetching deployment files...');
            
            $response = Http::timeout(30)->post($url, $payload);
            
            if (!$response->successful()) {
                $this->licenseError = __('Failed to fetch deployment files: ') . ($response->json('error') ?? $response->status());
                return false;
            }

            $data = $response->json();
            $files = $data['files'] ?? [];

            // Save Migrations
            if (isset($files['migrations'])) {
                $path = database_path('migrations');
                if (!file_exists($path)) mkdir($path, 0755, true);
                foreach ($files['migrations'] as $name => $content) {
                    file_put_contents($path . '/' . $name, $content);
                }
            }

            // Save Seeders
            if (isset($files['seeders'])) {
                $path = database_path('seeders');
                if (!file_exists($path)) mkdir($path, 0755, true);
                foreach ($files['seeders'] as $name => $content) {
                    file_put_contents($path . '/' . $name, $content);
                }
            }

            Log::info('[Installer] Deployment files fetched and saved.');
            return true;
        } catch (\Exception $e) {
            Log::error('[Installer] Failed to fetch files: ' . $e->getMessage());
            $this->licenseError = __('Error downloading deployment files.');
            return false;
        }
    }

    protected function verifyResponseSignature(array $data, ?string $overrideKey = null): bool
    {
        if (!isset($data['signature'])) return false;
        
        $signature = base64_decode($data['signature']);
        $payloadData = $data;
        unset($payloadData['signature']);
        
        ksort($payloadData);
        $json = json_encode($payloadData);
        
        $publicKey = $overrideKey ?: \Illuminate\Support\Facades\Cache::get('license_public_key') ?: config('license.public_key');
        
        return openssl_verify($json, $signature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
    }


    public $migrationMode = 'migrate'; // migrate or migrate:fresh

    public function setupDatabase()
    {
        file_put_contents('/tmp/debug_installer.log', "[" . date('Y-m-d H:i:s') . "] L248: setupDatabase started\n", FILE_APPEND);
        $this->dbError = '';
        $this->isInstalling = true;
        $this->installProgress = 5;
        $this->installStatus = __('Connecting to database...');

        try {
            $test = $this->installerService->testDbConnection($this->dbConfig);
        } catch (\Exception $e) {
            $test = ['success' => false, 'message' => $e->getMessage()];
        }

        if ($test['success']) {
            try {
                $this->installerService->updateEnv([
                    'DB_HOST' => $this->dbConfig['host'],
                    'DB_PORT' => $this->dbConfig['port'],
                    'DB_DATABASE' => $this->dbConfig['database'],
                    'DB_USERNAME' => $this->dbConfig['username'],
                    'DB_PASSWORD' => $this->dbConfig['password'],
                    'APP_URL' => url('/'),
                ]);
                
                config([
                    'database.connections.mysql.host' => $this->dbConfig['host'],
                    'database.connections.mysql.port' => $this->dbConfig['port'],
                    'database.connections.mysql.database' => $this->dbConfig['database'],
                    'database.connections.mysql.username' => $this->dbConfig['username'],
                    'database.connections.mysql.password' => $this->dbConfig['password'],
                ]);

                \Illuminate\Support\Facades\DB::purge('mysql');
                \Illuminate\Support\Facades\DB::reconnect('mysql');
                
                // Check for existing tables
                try {
                    $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
                    if (count($tables) > 0) {
                        $this->isInstalling = false;
                        $this->showDbPrompt = true;
                        $this->hasExistingTables = true;
                        return;
                    }
                } catch (\Exception $e) {}

                $this->migrationMode = 'migrate';
                $this->dispatch('start-migrations');
                return;
            } catch (\Exception $e) {
                $this->isInstalling = false;
                $this->dbError = __('Setup failed: ') . $e->getMessage();
            }
        } else {
            $this->isInstalling = false;
            $this->dbError = __('Connection failed: ') . $test['message'];
        }
    }

    public function startFreshInstall()
    {
        $this->showDbPrompt = false;
        $this->isInstalling = true;
        $this->migrationMode = 'migrate:fresh';
        $this->dispatch('start-migrations');
    }

    public function keepDataUpdateAdmin()
    {
        $this->showDbPrompt = false;
        $this->step = 4;
    }

    public function skipToFinish()
    {
        $this->installerService->markAsInstalled();
        $this->step = 5;
    }

    #[On('start-migrations')]
    public function runMigrations()
    {
        file_put_contents('/tmp/debug_installer.log', "[" . date('Y-m-d H:i:s') . "] runMigrations triggered\n", FILE_APPEND);
        $this->installProgress = 40;
        $this->installStatus = __('Creating database tables...');

        try {
            set_time_limit(300);
            file_put_contents('/tmp/debug_installer.log', "[" . date('Y-m-d H:i:s') . "] Running artisan " . $this->migrationMode . "...\n", FILE_APPEND);
            \Illuminate\Support\Facades\Artisan::call($this->migrationMode, ['--force' => true]);
            file_put_contents('/tmp/debug_installer.log', "[" . date('Y-m-d H:i:s') . "] artisan " . $this->migrationMode . " finished\n", FILE_APPEND);
            
            $this->dispatch('start-seeders');
        } catch (\Exception $e) {
            file_put_contents('/tmp/debug_installer.log', "[" . date('Y-m-d H:i:s') . "] runMigrations CRASHED: " . $e->getMessage() . "\n", FILE_APPEND);
            Log::error('[Installer] Migration failed: ' . $e->getMessage());
            $this->isInstalling = false;
            $this->dbError = __('Setup failed: ') . $e->getMessage();
        }
    }

    #[On('start-seeders')]
    public function runSeeders()
    {
        $this->installProgress = 80;
        $this->installStatus = __('Seeding initial data...');

        try {
            set_time_limit(300);
            // Only seed if we are in fresh mode or if the tables are empty
            if ($this->migrationMode == 'migrate:fresh' || !$this->hasExistingTables) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
                Log::info('[Installer] Seeding completed.');
            } else {
                Log::info('[Installer] Skipping seeding as tables already exist.');
            }

            $this->installProgress = 95;
            $this->installStatus = __('Finishing up...');

            $licenseKey    = session('installer_license_key');
            $licenseData   = session('installer_license_data');

            if ($licenseKey && $licenseData) {
                \App\Models\LicenseCache::updateOrCreate(
                    ['license_key' => $licenseKey],
                    [
                        'status'           => $licenseData['status'] ?? 'active',
                        'restriction_mode' => $licenseData['restriction_mode'] ?? 'full_site',
                        'show_licensing_ui' => (bool) ($licenseData['show_licensing_ui'] ?? true),
                        'payload_json'     => $licenseData,
                        'signature'        => $licenseData['signature'],
                        'last_verified_at' => now(),
                    ]
                );

                // Persist to SiteSettings for robustness (Coolify/Docker)
                \App\Models\SiteSetting::updateOrCreate(
                    ['key' => 'license_product_code'],
                    ['value' => session('installer_product_code')]
                );
                \App\Models\SiteSetting::updateOrCreate(
                    ['key' => 'license_key'],
                    ['value' => $licenseKey]
                );

                session()->forget(['installer_license_key', 'installer_license_data', 'installer_product_code']);
            }

            $this->isInstalling = false;
            $this->step = 4;
        } catch (\Exception $e) {
            Log::error('[Installer] Seeding failed: ' . $e->getMessage());
            $this->isInstalling = false;
            $this->dbError = __('Setup failed: ') . $e->getMessage();
        }
    }


    public function render()
    {
        return view('livewire.installer')
            ->layout('layouts.installer');
    }
}
