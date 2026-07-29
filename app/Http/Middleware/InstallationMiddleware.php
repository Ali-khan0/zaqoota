<?php

namespace App\Http\Middleware;

use Closure;

class InstallationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Bypass purchase key check - always allow request to proceed
        return $next($request);
    }
}
