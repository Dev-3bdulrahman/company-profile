<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * HasApiResponse
 * 
 * Provides standardized methods for JSON responses.
 * Ensures consistency between web (AJAX) and mobile API layers.
 */
trait HasApiResponse
{
    /**
     * Return a success JSON response.
     */
    protected function success(mixed $data = [], string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => __($message),
            'data' => $data,
        ], $code);
    }

    /**
     * Return an error JSON response.
     */
    protected function error(string $message = 'Error', int $code = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => __($message),
            'errors' => $errors,
        ], $code);
    }
}
