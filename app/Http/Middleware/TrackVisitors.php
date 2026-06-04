<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\VisitorLog;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Execute request first so tracking doesn't block the user response
        $response = $next($request);

        try {
            // Exclude admin pages, api routes, and debug paths
            if ($request->is('admin*') || $request->is('api*') || $request->is('_*')) {
                return $response;
            }

            $ip = $request->ip();
            $userAgent = $request->header('User-Agent', '');
            $referer = $request->header('referer');
            $urlPath = '/' . ltrim($request->getPathInfo(), '/');

            // Parse Browser
            $browser = 'Unknown';
            if (preg_match('/msie|trident/i', $userAgent)) {
                $browser = 'Internet Explorer';
            } elseif (preg_match('/edg/i', $userAgent)) {
                $browser = 'Edge';
            } elseif (preg_match('/opr/i', $userAgent)) {
                $browser = 'Opera';
            } elseif (preg_match('/firefox|fxios/i', $userAgent)) {
                $browser = 'Firefox';
            } elseif (preg_match('/chrome|crios/i', $userAgent)) {
                $browser = 'Chrome';
            } elseif (preg_match('/safari/i', $userAgent)) {
                $browser = 'Safari';
            }

            // Parse Platform
            $platform = 'Unknown';
            if (preg_match('/windows/i', $userAgent)) {
                $platform = 'Windows';
            } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
                $platform = 'macOS';
            } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
                $platform = 'iOS';
            } elseif (preg_match('/android/i', $userAgent)) {
                $platform = 'Android';
            } elseif (preg_match('/linux/i', $userAgent)) {
                $platform = 'Linux';
            }

            // Parse Device Type
            $deviceType = 'desktop';
            if (preg_match('/bot|crawl|slurp|spider|mediapartners|google|twitter|facebook|github/i', $userAgent)) {
                $deviceType = 'robot';
            } elseif (preg_match('/ipad|tablet|playbook|silk/i', $userAgent)) {
                $deviceType = 'tablet';
            } elseif (preg_match('/mobile|iphone|ipod|android|blackberry|opera mini|iemobile|phone/i', $userAgent)) {
                $deviceType = 'mobile';
            }

            // Detect Proxies
            $proxyHeadersList = [
                'via',
                'forwarded',
                'x-forwarded-for',
                'x-forwarded-proto',
                'x-forwarded-host',
                'x-forwarded-port',
                'x-real-ip',
                'cf-connecting-ip',
                'true-client-ip',
            ];
            $foundProxyHeaders = [];
            foreach ($proxyHeadersList as $headerName) {
                if ($request->headers->has($headerName)) {
                    $foundProxyHeaders[$headerName] = $request->headers->get($headerName);
                }
            }
            $isProxy = !empty($foundProxyHeaders);

            // Fetch Geo-IP Location with caching (30 days) and timeout
            $country = 'Unknown';
            $city = 'Unknown';

            // Only fetch for public IPs to avoid error results on localhost
            $isPublicIp = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
            if ($isPublicIp) {
                $cacheKey = 'ip_geo_' . str_replace([':', '.'], '_', $ip);
                $geo = cache()->remember($cacheKey, now()->addDays(30), function () use ($ip) {
                    try {
                        $apiResponse = Http::timeout(0.5)->get("http://ip-api.com/json/{$ip}");
                        if ($apiResponse->successful()) {
                            $data = $apiResponse->json();
                            if (isset($data['status']) && $data['status'] === 'success') {
                                return [
                                    'country' => $data['country'] ?? 'Unknown',
                                    'city' => $data['city'] ?? 'Unknown',
                                ];
                            }
                        }
                    } catch (\Throwable $e) {
                        // Fail silently and return defaults
                    }
                    return [
                        'country' => 'Unknown',
                        'city' => 'Unknown',
                    ];
                });

                $country = $geo['country'];
                $city = $geo['city'];
            } else {
                $country = 'Local Loopback';
                $city = 'localhost';
            }

            // Log visitor details
            VisitorLog::create([
                'ip_address' => $ip,
                'url_path' => $urlPath,
                'referer' => $referer ? substr($referer, 0, 500) : null,
                'user_agent' => $userAgent,
                'device_type' => $deviceType,
                'browser' => $browser,
                'platform' => $platform,
                'country' => $country,
                'city' => $city,
                'is_proxy' => $isProxy,
                'proxy_headers' => $isProxy ? $foundProxyHeaders : null,
            ]);

        } catch (\Throwable $e) {
            // Keep middleware completely fail-safe
            report($e);
        }

        return $response;
    }
}
