<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * HealthController
 *
 * Provides API and database health-check endpoints.
 * Used by Docker's HEALTHCHECK directive and external monitoring.
 */
class HealthController extends Controller
{
    /**
     * GET /api/health
     *
     * Returns overall API health status.
     */
    public function check(Request $request): JsonResponse
    {
        return response()->json([
            'status'    => 'ok',
            'service'   => config('app.name'),
            'version'   => config('app.crm.version'),
            'env'       => config('app.env'),
            'timestamp' => now()->toIso8601String(),
        ], 200);
    }

    /**
     * GET /api/health/db
     *
     * Checks PostgreSQL connectivity.
     */
    public function database(Request $request): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();

            return response()->json([
                'status'   => 'ok',
                'database' => $dbName,
                'driver'   => config('database.default'),
                'timestamp'=> now()->toIso8601String(),
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status'   => 'error',
                'message'  => 'Database connection failed',
                'timestamp'=> now()->toIso8601String(),
            ], 503);
        }
    }
}
