<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AntiScrapingProtection
{
    /**
     * Known scraper user agents (only aggressive scrapers)
     */
    protected array $blockedAgents = [
        'httrack', 'scrapy', 'python-requests',
        'go-http-client', 'libwww', 'lwp-trivial',
        'sitesucker', 'webcopier', 'webzip',
        'teleport', 'webcapture', 'webstripper', 'sitesnagger',
        'blackwidow', 'pavuk', 'prowebwalker', 'netspider',
    ];

    /**
     * SEO-critical paths that should bypass anti-scraping
     */
    protected array $exemptPaths = [
        'robots.txt',
        'sitemap.xml',
        'ads.txt',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 0. Exempt SEO-critical paths — bots MUST access these
        $path = ltrim($request->path(), '/');
        foreach ($this->exemptPaths as $exempt) {
            if ($path === $exempt) {
                return $next($request);
            }
        }

        $ip = $request->ip();
        $ua = strtolower($request->userAgent() ?? '');

        // 1. Check if IP is temporarily blocked
        if (Cache::get('blocked_' . md5($ip))) {
            return response('Access temporarily blocked.', 429);
        }

        // 2. Block known scraper user agents
        foreach ($this->blockedAgents as $agent) {
            if (str_contains($ua, $agent)) {
                return response('Access Denied', 403);
            }
        }

        // 3. Rate Limiting: Max 120 requests per minute per IP
        $rateLimitKey = 'rate_limit_' . md5($ip);
        $requestCount = Cache::get($rateLimitKey, 0);
        
        if ($requestCount >= 120) {
            return response('Too Many Requests. Please slow down.', 429);
        }
        
        Cache::put($rateLimitKey, $requestCount + 1, 60);

        // 4. Rapid request detection: Block if more than 30 requests in 5 seconds
        $rapidKey = 'rapid_' . md5($ip);
        $rapidCount = Cache::get($rapidKey, 0);
        
        if ($rapidCount >= 30) {
            Cache::put('blocked_' . md5($ip), true, 300);
            return response('Access temporarily blocked due to suspicious activity.', 429);
        }
        
        Cache::put($rapidKey, $rapidCount + 1, 5);

        // Get response
        $response = $next($request);

        // 5. Add security headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
