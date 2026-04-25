<?php

namespace App\Services;

use App\Models\LicenseCache;
use Carbon\Carbon;

class LicenseStateService
{
    /**
     * Check if the product is currently usable.
     */
    public function isUsable(): bool
    {
        $cache = $this->getCache();

        if (!$cache || !$cache->license_key) {
            return false;
        }

        // 1. If status is explicitly suspended/revoked/expired from server
        if (in_array($cache->status, ['suspended', 'revoked', 'expired'])) {
            return false;
        }

        // 2. Check Expiry
        if ($cache->expires_at && $cache->expires_at->isPast()) {
            // Check if we are still within server-provided grace period
            if ($cache->grace_until && $cache->grace_until->isPast()) {
                return false;
            }
            
            // If no server grace, or server grace expired, we still check local connection grace
        }

        // 3. Connection Grace Period (If server is down)
        // If last_verified_at is too old, we might want to block, but only after config grace days
        if ($cache->last_verified_at) {
            $graceDays = config('license.local_grace_period_days', 7);
            if ($cache->last_verified_at->addDays($graceDays)->isPast()) {
                return false;
            }
        }

        return true;
    }


    /**
     * Get the latest license cache record.
     */
    public function getCache(): ?LicenseCache
    {
        return LicenseCache::latest()->first();
    }

    /**
     * Get current status details.
     */
    public function getStatusDetails(): array
    {
        $cache = $this->getCache();
        
        return [
            'key' => $cache->license_key ?? 'None',
            'status' => $cache->status ?? 'Unlicensed',
            'expires_at' => $cache->expires_at,
            'last_verified_at' => $cache->last_verified_at,
            'is_usable' => $this->isUsable(),
            'check_frequency_hours' => config('license.check_frequency', 24),
            'local_grace_period_days' => config('license.local_grace_period_days', 7),
            'is_in_local_grace' => $this->isInLocalGrace($cache),
        ];
    }

    /**
     * Determine if we are currently using the local grace period.
     */
    protected function isInLocalGrace(?LicenseCache $cache): bool
    {
        if (!$cache || !$cache->last_verified_at) return false;
        
        $frequencyHours = config('license.check_frequency', 24);
        return $cache->last_verified_at->addHours($frequencyHours)->isPast();
    }

}
