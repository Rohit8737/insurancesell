<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class FilterBotTraffic
{
    /**
     * Known bot user agents
     */
    protected array $botAgents = [
        'facebookexternalhit',
        'Facebot',
        'Googlebot',
        'bingbot',
        'Slurp',           // Yahoo
        'DuckDuckBot',
        'Baiduspider',
        'YandexBot',
        'Sogou',
        'Exabot',
        'ia_archiver',     // Alexa
        'Twitterbot',
        'LinkedInBot',
        'Pinterest',
        'WhatsApp',
        'TelegramBot',
        'Discordbot',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->userAgent() ?? '';
        
        $isBot = false;
        
        foreach ($this->botAgents as $botAgent) {
            if (Str::contains($userAgent, $botAgent, true)) {
                $isBot = true;
                break;
            }
        }
        
        // Share isBot variable with all views
        view()->share('isBot', $isBot);
        
        return $next($request);
    }
}
