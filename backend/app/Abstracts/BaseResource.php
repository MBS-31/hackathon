<?php

namespace App\Abstracts;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * BaseResource
 *
 * Abstract base for all CRM API resource (response transformer) classes.
 * All JSON responses follow the envelope:
 *   { data: {...}, meta: {...} }
 *
 * Domain resources extend this and implement toArray().
 */
abstract class BaseResource extends JsonResource
{
    /**
     * Wrap all resources under a 'data' key.
     */
    public static $wrap = 'data';

    /**
     * Add standard metadata to every resource response.
     */
    public function with($request): array
    {
        return [
            'meta' => [
                'api_version' => config('app.crm.api_version', 'v1'),
                'timestamp'   => now()->toIso8601String(),
            ],
        ];
    }
}
