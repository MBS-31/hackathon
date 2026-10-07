<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

/**
 * ApiRateLimiter
 *
 * Applies per-user or per-IP throttling to API routes.
 * Authenticated users get a higher limit than anonymous callers.
 */
class ApiRateLimiter
{
    public function handle(Request $request, Closure $next, string $limiterKey = 'api'): Response
    {
        $key = $request->user()
            ? "user:{$request->user()->id}"
            : "ip:{$request->ip()}";

        $maxAttempts = $request->user() ? 300 : 60;

        if (RateLimiter::tooManyAttempts("{$limiterKey}:{$key}", $maxAttempts)) {
            $seconds = RateLimiter::availableIn("{$limiterKey}:{$key}");

            return response()->json([
                'status'  => 'error',
                'code'    => 'too_many_requests',
                'message' => 'Too many requests. Please retry after ' . $seconds . ' seconds.',
                'retry_after' => $seconds,
            ], 429)->header('Retry-After', $seconds);
        }

        RateLimiter::hit("{$limiterKey}:{$key}", 60);

        return $next($request);
    }
}
