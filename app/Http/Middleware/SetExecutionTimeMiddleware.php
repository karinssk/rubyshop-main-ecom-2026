<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetExecutionTimeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set execution time limit for web requests
        if (!app()->runningInConsole()) {
            set_time_limit(600); // 10 minutes
            ini_set('memory_limit', '512M');
        }

        // Ignore user abort to prevent incomplete operations
        ignore_user_abort(true);

        return $next($request);
    }
}
