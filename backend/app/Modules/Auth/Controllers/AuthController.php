<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AuthController
 *
 * Handles user authentication lifecycle:
 * login, register, logout, token refresh, password management.
 *
 * Business logic is implemented in Set 1B (Auth Module).
 */
class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }

    public function register(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }

    public function logout(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }

    public function refresh(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }

    public function changePassword(Request $request): JsonResponse
    {
        return response()->json(['status' => 'stub', 'message' => 'Auth module — coming in Set 1B'], 501);
    }
}
