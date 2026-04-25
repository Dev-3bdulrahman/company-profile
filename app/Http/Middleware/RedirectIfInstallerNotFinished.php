<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfInstallerNotFinished
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $installedFile = storage_path('installed');
        $isInstalled = File::exists($installedFile);
        
        // Check if we are already on the install page or making a livewire request
        $isInstallerPage = $request->is('install') || $request->is('install/*');
        $isLivewire = $request->is('livewire/*') || $request->hasHeader('X-Livewire');
        $isAsset = $request->is('assets/*') || $request->is('css/*') || $request->is('js/*') || $request->is('storage/*');

        if (!$isInstalled && !$isInstallerPage && !$isLivewire && !$isAsset) {
            return redirect('/install');
        }

        // Prevent accessing /install if already installed (except for livewire calls)
        if ($isInstalled && $isInstallerPage && !$isLivewire) {
            return redirect('/');
        }

        return $next($request);
    }
}
