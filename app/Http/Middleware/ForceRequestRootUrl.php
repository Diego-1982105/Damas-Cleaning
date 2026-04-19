<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Aligns generated route/redirect URLs with the hostname the client used.
 * Prevents redirect loops when APP_URL differs from the public URL (e.g. DO
 * default domain vs custom domain, or misconfigured APP_URL).
 */
final class ForceRequestRootUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('testing')) {
            return $next($request);
        }

        $host = $request->getHost();

        // Local dev on your machine; still run on DO default host even if APP_ENV was left as "local".
        if (app()->environment('local') && ! str_ends_with($host, '.ondigitalocean.app')) {
            return $next($request);
        }

        URL::forceScheme('https');
        URL::forceRootUrl('https://'.$request->getHttpHost());

        return $next($request);
    }
}
