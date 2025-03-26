<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class ForceHttpsUrls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS for all URLs
        URL::forceScheme('https');

        // If the request is not secure, redirect to HTTPS
        if (!$request->secure() && (env('APP_ENV') === 'production' || app()->isLocal())) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
