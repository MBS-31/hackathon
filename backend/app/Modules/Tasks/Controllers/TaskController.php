<?php

namespace App\Modules\Tasks\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TaskController
 *
 * Stub controller for the Tasks module.
 * Full implementation will be added in subsequent sets.
 */
class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Tasks', 'message' => 'To be implemented'], 501);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Tasks', 'message' => 'To be implemented'], 501);
    }

    public function show(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Tasks', 'message' => 'To be implemented'], 501);
    }

    public function update(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Tasks', 'message' => 'To be implemented'], 501);
    }

    public function destroy(Request $request, int|string $id): JsonResponse
    {
        return response()->json(['status' => 'stub', 'module' => 'Tasks', 'message' => 'To be implemented'], 501);
    }
}
