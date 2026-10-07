<?php

namespace App\Modules\Audit\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AuditController
 *
 * Stub controller for the Audit module.
 * Full implementation will be added in subsequent sets.
 */
class AuditController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Audit', 'message' => 'To be implemented'], 501);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Audit', 'message' => 'To be implemented'], 501);
    }

    public function show(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Audit', 'message' => 'To be implemented'], 501);
    }

    public function update(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Audit', 'message' => 'To be implemented'], 501);
    }

    public function destroy(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Audit', 'message' => 'To be implemented'], 501);
    }
}
