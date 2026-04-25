<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Precise path detection
        $path = trim($request->getPathInfo(), '/');
        $isAdmin = str_starts_with($path, 'admin') || $path === 'admin' || str_starts_with($path, 'login') || $path === 'login' || str_starts_with($path, 'logout') || $path === 'logout';

        // 2. Handle Livewire/AJAX requests by checking the Referer
        if (!$isAdmin && ($request->is('livewire/*') || $request->ajax() || $request->hasHeader('X-Livewire'))) {
            $referer = $request->header('referer');
            if ($referer) {
                try {
                    $refPath = trim(parse_url($referer, PHP_URL_PATH), '/');
                    if (str_starts_with($refPath, 'admin') || $refPath === 'admin' || str_starts_with($refPath, 'login') || $refPath === 'login') {
                        $isAdmin = true;
                    }
                } catch (\Exception $e) {}
            }
        }

        // 3. Apply the appropriate locale
        $localeKey = $isAdmin ? 'locale_dashboard' : 'locale_landing';
        
        // Check for 'lang' query parameter (SEO / Sitemap compatibility)
        if ($request->has('lang') && in_array($request->query('lang'), ['ar', 'en'])) {
            $locale = $request->query('lang');
            session([$localeKey => $locale]);
            cookie()->queue(cookie()->forever($localeKey, $locale));
        } else {
            $locale = session($localeKey, $request->cookie($localeKey, config('app.locale')));
        }
        
        app()->setLocale($locale);

        return $next($request);
    }
}
