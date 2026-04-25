<?php

namespace App\Http\Middleware;

use App\Services\LicenseStateService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLicenseIsValid
{
    protected LicenseStateService $stateService;

    public function __construct(LicenseStateService $stateService)
    {
        $this->stateService = $stateService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if app is installed
        if (!\Illuminate\Support\Facades\File::exists(storage_path('installed')) && !$request->is('install*')) {
            return redirect()->route('install');
        }

        // 2. Skip if already on activation/install page
        if ($request->is('license/activate*') || $request->is('install*') || $request->routeIs('admin.settings.license')) {
            return $next($request);
        }


        // 2. Check if product is usable
        if (!$this->stateService->isUsable()) {
            $cache = $this->stateService->getCache();
            $mode = $cache->restriction_mode ?? 'full_site';

            // Mode 1: Admin Only Lock (Allow public site, block /admin)
            if ($mode === 'admin_only') {
                if ($request->is('admin*')) {
                    return redirect()->route('license.activate')->with('error', __('Please activate your product to access the admin dashboard.'));
                }
                return $next($request);
            }

            // Mode 2: Full Site Lock (Default - block everything except license page)
            return redirect()->route('license.activate')->with('error', __('This product is not activated. Please provide a valid license key.'));
        }


        return $next($request);
    }
}
