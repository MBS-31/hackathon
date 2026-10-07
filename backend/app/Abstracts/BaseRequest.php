<?php

namespace App\Abstracts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * BaseRequest
 *
 * Abstract base for all CRM Form Request validators.
 * Overrides failedValidation to always return JSON (not redirect).
 */
abstract class BaseRequest extends FormRequest
{
    /**
     * All API requests are authorized at the route level via JWT + permissions.
     * Individual requests can override this to add additional checks.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Return JSON validation errors instead of redirecting.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => 'error',
                'code'    => 'validation_failed',
                'message' => 'The given data was invalid.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
