<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorHistory
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip if not installed
        if (!\Illuminate\Support\Facades\File::exists(storage_path('installed'))) {
            return $next($request);
        }

        // Skip for AJAX/Livewire requests or Admin users
        if ($request->ajax() || auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }


        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Cache Geo Data for 24 hours per IP
        $geo = Cache::remember("geo_ip_{$ip}", 86400, function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,country,city");
                if ($response->successful() && $response->json('status') === 'success') {
                    return [
                        'country' => $response->json('country'),
                        'city' => $response->json('city')
                    ];
                }
            } catch (\Exception $e) {
            }
            return ['country' => 'Unknown', 'city' => 'Unknown'];
        });

        // Check if unique today
        $isUnique = !VisitorLog::where('ip_address', $ip)
            ->whereDate('created_at', today())
            ->exists();

        VisitorLog::create([
            'ip_address' => $ip,
            'country' => $geo['country'],
            'city' => $geo['city'],
            'user_agent' => $userAgent,
            'device_type' => $this->getDeviceType($userAgent),
            'browser' => $this->getBrowser($userAgent),
            'platform' => $this->getPlatform($userAgent),
            'url' => $request->fullUrl(),
            'locale' => app()->getLocale(),
            'referrer' => $request->header('referer'),
            'is_unique' => $isUnique,
        ]);

        return $next($request);
    }

    private function getBrowser($user_agent)
    {
        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR'))
            return 'Opera';
        if (strpos($user_agent, 'Edge'))
            return 'Edge';
        if (strpos($user_agent, 'Chrome'))
            return 'Chrome';
        if (strpos($user_agent, 'Safari'))
            return 'Safari';
        if (strpos($user_agent, 'Firefox'))
            return 'Firefox';
        return 'Unknown';
    }

    private function getPlatform($user_agent)
    {
        if (preg_match('/linux/i', $user_agent))
            return 'Linux';
        if (preg_match('/macintosh|mac os x/i', $user_agent))
            return 'Mac';
        if (preg_match('/windows|win32/i', $user_agent))
            return 'Windows';
        if (preg_match('/iphone/i', $user_agent))
            return 'iPhone';
        if (preg_match('/android/i', $user_agent))
            return 'Android';
        return 'Unknown';
    }

    private function getDeviceType($user_agent)
    {
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobi))/i', $user_agent))
            return 'Tablet';
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $user_agent))
            return 'Mobile';
        return 'Desktop';
    }
}
