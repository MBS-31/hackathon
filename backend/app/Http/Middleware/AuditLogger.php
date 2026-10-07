<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * AuditLogger
 *
 * Logs inbound API requests (method, URI, user, IP) and outbound response codes
 * to the dedicated 'audit' log channel for compliance and troubleshooting.
 */
class AuditLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip health-check routes to avoid log noise
        $excludedRoutes = config('app.crm.audit.exclude_routes', []);
        if (in_array($request->route()?->getName(), $excludedRoutes)) {
            return $response;
        }

        if (config('app.crm.audit.enabled', true)) {
            Log::channel('audit')->info('api.request', [
                'method'     => $request->method(),
                'uri'        => $request->getRequestUri(),
                'route'      => $request->route()?->getName(),
                'user_id'    => $request->user()?->id,
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status'     => $response->getStatusCode(),
                'timestamp'  => now()->toIso8601String(),
            ]);
        }

        return $response;
    }
}
