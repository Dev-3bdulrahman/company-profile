<?php

namespace App\Services;

use App\Models\LicenseCache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class LicenseService
{
    /**
     * Activate or Refresh a license.
     */
    public function verify(string $licenseKey, bool $force = false): array
    {
        $cache = LicenseCache::where('license_key', $licenseKey)->first();

        // 1. Skip server check if verified recently (unless forced)
        if (!$force && $cache && $cache->last_verified_at) {
            $hoursSinceLastCheck = $cache->last_verified_at->diffInHours(now());
            if ($hoursSinceLastCheck < config('license.check_frequency', 24)) {
                return ['success' => true, 'data' => $cache->payload_json, 'cached' => true];
            }
        }

        $productCode = \App\Models\SiteSetting::getValue('license_product_code', config('license.product_code'));

        $payload = [
            'license_key' => $licenseKey,
            'product_code' => $productCode,
            'domain' => request()->getHost(),
            'ip_address' => request()->ip(),
            'machine_fingerprint' => $this->getFingerprint(),
            'timestamp' => now()->timestamp,
            'nonce' => bin2hex(random_bytes(16)),
        ];

        try {
            $url = config('license.server_url') . '/api/license/authorize';
            Log::info("Attempting license verification at: " . $url);
            
            $response = Http::timeout(config('license.timeout', 10))
                ->post($url, $payload);

            Log::info("License server response status: " . $response->status());
            Log::info("License server response body: " . $response->body());

            if ($response->successful()) {

                $data = $response->json();
                
                if ($this->verifySignature($data)) {
                    $this->updateLocalCache($licenseKey, $data);
                    return ['success' => true, 'data' => $data];
                }

                return ['success' => false, 'error' => 'Invalid response signature. Security alert.'];
            }

            $error = $response->json('error.message') ?? 'Server returned an error.';
            
            if ($response->status() === 403) {
                 $this->updateLocalStatus($licenseKey, $response->json('error.code', 'INVALID'));
            }

            return ['success' => false, 'error' => $error, 'status_code' => $response->status()];

        } catch (\Exception $e) {
            Log::warning("License server unreachable: " . $e->getMessage());
            
            // If we have a cached valid license, we can "succeed" during grace period
            if ($cache && $cache->status === 'active') {
                return [
                    'success' => true, 
                    'data' => $cache->payload_json, 
                    'warning' => 'CONNECTION_FAILED_USING_CACHE'
                ];
            }

            return ['success' => false, 'error' => 'CONNECTION_FAILED'];
        }
    }


    /**
     * Verify the signature using the public key.
     */
    protected function verifySignature(array $data, bool $isRetry = false): bool
    {
        if (!isset($data['signature'])) {
            return false;
        }

        $signature = base64_decode($data['signature']);
        $payloadData = $data;
        unset($payloadData['signature']);

        ksort($payloadData);
        $json = json_encode($payloadData);

        // Get the public key (prefer dynamic from DB, fallback to config)
        $publicKey = $this->getStoredPublicKey() ?: config('license.public_key');

        $result = openssl_verify($json, $signature, $publicKey, OPENSSL_ALGO_SHA256);

        if ($result === 1) {
            return true;
        }

        // If failed and not a retry, try fetching latest key from server
        if (!$isRetry) {
            Log::info("Signature verification failed. Attempting to fetch fresh public key...");
            if ($this->refreshPublicKey()) {
                return $this->verifySignature($data, true);
            }
        }

        return false;
    }

    /**
     * Fetch the latest public key from the authority.
     */
    public function refreshPublicKey(): bool
    {
        try {
            $url = config('license.server_url') . '/api/license/public-key';
            $response = Http::timeout(5)->get($url);

            if ($response->successful() && isset($response->json()['public_key'])) {
                $newKey = $response->json()['public_key'];
                $this->storePublicKey($newKey);
                Log::info("Public key refreshed successfully.");
                return true;
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch public key: " . $e->getMessage());
        }

        return false;
    }

    protected function getStoredPublicKey(): ?string
    {
        return Cache::get('license_public_key');
    }

    protected function storePublicKey(string $key): void
    {
        Cache::forever('license_public_key', $key);
    }


    /**
     * Update local database cache.
     */
    protected function updateLocalCache(string $key, array $data): void
    {
        LicenseCache::updateOrCreate(
            ['license_key' => $key],
            [
                'status' => $data['status'] ?? 'active',
                'restriction_mode' => $data['restriction_mode'] ?? 'full_site',
                'show_licensing_ui' => (bool) ($data['show_licensing_ui'] ?? true),
                'payload_json' => $data,
                'signature' => $data['signature'],
                'last_verified_at' => now(),
                'expires_at' => isset($data['expires_at']) ? \Carbon\Carbon::parse($data['expires_at']) : null,
                'grace_until' => isset($data['grace_until']) ? \Carbon\Carbon::parse($data['grace_until']) : null,
            ]
        );

        // Also persist to SiteSettings for robustness
        \App\Models\SiteSetting::updateOrCreate(
            ['key' => 'license_key'],
            ['value' => $key]
        );
    }

    protected function updateLocalStatus(string $key, string $status): void
    {
        LicenseCache::where('license_key', $key)->update(['status' => $status, 'last_verified_at' => now()]);
    }

    public function getFingerprint(): string
    {
        return md5(php_uname() . php_sapi_name() . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'local'));
    }
}
