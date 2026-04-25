<?php

namespace App\Console\Commands;

use App\Models\LicenseCache;
use App\Services\LicenseService;
use Illuminate\Console\Command;

class LicenseRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'license:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the license status from the authority server';

    /**
     * Execute the console command.
     */
    public function handle(LicenseService $licenseService)
    {
        $cache = LicenseCache::latest()->first();

        if (!$cache || !$cache->license_key) {
            $this->error('No license key found to refresh.');
            return 1;
        }

        $this->info("Refreshing license: {$cache->license_key}...");

        $result = $licenseService->verify($cache->license_key);

        if ($result['success']) {
            $this->info('License refreshed successfully.');
            return 0;
        }

        if ($result['error'] === 'CONNECTION_FAILED') {
            $this->warn('Server unreachable. Keeping local cache (Grace Period may apply).');
            return 0;
        }

        $this->error("License check failed: {$result['error']}");
        return 1;
    }
}
