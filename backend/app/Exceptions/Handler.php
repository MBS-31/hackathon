<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * Exception Handler
 *
 * Renders all API exceptions as structured JSON responses.
 * All responses follow the envelope:
 *   { status, code, message, errors?, data? }
 */
class Handler extends ExceptionHandler
{
    /**
     * Exceptions that should not be reported.
     */
    protected $dontReport = [
        ValidationException::class,
        ModelNotFoundException::class,
        AuthenticationException::class,
        UnauthorizedException::class,
    ];

    /**
     * Render a JSON API error response.
     * Called from bootstrap/app.php for all api/* routes.
     */
    public function renderApiException(Throwable $e, Request $request): JsonResponse
    {
        // Validation errors
        if ($e instanceof ValidationException) {
            return response()->json([
                'status'  => 'error',
                'code'    => 'validation_failed',
                'message' => 'The given data was invalid.',
                'errors'  => $e->errors(),
            ], 422);
        }

        // Model not found (convert to 404)
        if ($e instanceof ModelNotFoundException) {
            $model = class_basename($e->getModel());
            return response()->json([
                'status'  => 'error',
                'code'    => 'not_found',
                'message' => "{$model} not found.",
            ], 404);
        }

        // Route not found
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'status'  => 'error',
                'code'    => 'route_not_found',
                'message' => 'The requested endpoint does not exist.',
            ], 404);
        }

        // Unauthenticated
        if ($e instanceof AuthenticationException) {
            return response()->json([
                'status'  => 'error',
                'code'    => 'unauthenticated',
                'message' => 'You must be authenticated to access this resource.',
            ], 401);
        }

        // Unauthorized (Spatie permissions)
        if ($e instanceof UnauthorizedException) {
            return response()->json([
                'status'  => 'error',
                'code'    => 'forbidden',
                'message' => 'You do not have permission to perform this action.',
            ], 403);
        }

        // Generic HTTP exceptions (403, 429, etc.)
        if ($e instanceof HttpException) {
            return response()->json([
                'status'  => 'error',
                'code'    => 'http_error',
                'message' => $e->getMessage() ?: 'An HTTP error occurred.',
            ], $e->getStatusCode());
        }

        // Generic / unhandled exceptions
        $isDebug = config('app.debug', false);

        return response()->json([
            'status'  => 'error',
            'code'    => 'internal_server_error',
            'message' => $isDebug ? $e->getMessage() : 'An unexpected error occurred.',
            'trace'   => $isDebug ? collect(explode("\n", $e->getTraceAsString()))->take(10) : null,
        ], 500);
    }
}
