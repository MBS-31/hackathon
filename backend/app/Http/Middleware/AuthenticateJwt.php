<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * AuthenticateJwt
 *
 * Validates the JWT Bearer token on protected API routes.
 */
class AuthenticateJwt
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return $this->unauthorized('User not found');
            }
        } catch (TokenExpiredException $e) {
            return $this->unauthorized('Token has expired', 'token_expired');
        } catch (TokenInvalidException $e) {
            return $this->unauthorized('Token is invalid', 'token_invalid');
        } catch (JWTException $e) {
            return $this->unauthorized('Token not provided', 'token_absent');
        }

        return $next($request);
    }

    private function unauthorized(string $message, string $code = 'unauthenticated'): Response
    {
        return response()->json([
            'status'  => 'error',
            'code'    => $code,
            'message' => $message,
        ], 401);
    }
}
