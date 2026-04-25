<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LicenseClientService
{
    /**
     * Check if the application is licensed.
     */
    public function check(string $licenseKey): array
    {
        $cacheKey = 'license_check_' . md5($licenseKey);
        
        if (config('license.cache.enabled') && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $payload = [
            'license_key' => $licenseKey,
            'product_code' => config('license.product_code'),
            'domain' => request()->getHost(),
            'ip_address' => request()->ip(),
            'machine_fingerprint' => $this->getFingerprint(),
            'timestamp' => now()->timestamp,
            'nonce' => bin2hex(random_bytes(16)),
        ];

        try {
            $response = Http::timeout(10)
                ->post(config('license.server_url') . '/api/license/authorize', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($this->verifySignature($data)) {
                    $result = ['success' => true, 'data' => $data];
                    
                    if (config('license.cache.enabled')) {
                        Cache::put($cacheKey, $result, config('license.cache.ttl'));
                    }
                    
                    return $result;
                }

                return ['success' => false, 'error' => 'Invalid response signature.'];
            }

            $error = $response->json('error.message') ?? 'Server returned an error.';
            return ['success' => false, 'error' => $error];

        } catch (\Exception $e) {
            Log::error("License check failed: " . $e->getMessage());
            return ['success' => false, 'error' => 'Could not connect to license server.'];
        }
    }

    /**
     * Verify the signature of the response.
     */
    protected function verifySignature(array $data): bool
    {
        if (!isset($data['signature'])) {
            return false;
        }

        $signature = base64_decode($data['signature']);
        unset($data['signature']);

        // Canonicalize (same as server)
        ksort($data);
        $payload = json_encode($data);

        $publicKey = config('license.public_key');

        return openssl_verify($payload, $signature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
    }

    /**
     * Generate a unique fingerprint for this machine/installation.
     */
    protected function getFingerprint(): string
    {
        // Simple fingerprint based on server info
        return md5(php_uname() . php_sapi_name() . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'local'));
    }
}
