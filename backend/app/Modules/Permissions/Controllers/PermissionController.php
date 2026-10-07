<?php

namespace App\Modules\Permissions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * PermissionController
 *
 * Stub controller for the Permissions module.
 * Full implementation will be added in subsequent sets.
 */
class PermissionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Permissions', 'message' => 'To be implemented'], 501);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Permissions', 'message' => 'To be implemented'], 501);
    }

    public function show(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Permissions', 'message' => 'To be implemented'], 501);
    }

    public function update(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Permissions', 'message' => 'To be implemented'], 501);
    }

    public function destroy(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Permissions', 'message' => 'To be implemented'], 501);
    }
}
