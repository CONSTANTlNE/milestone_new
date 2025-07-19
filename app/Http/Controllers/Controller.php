<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;
use Illuminate\Support\Facades\Log;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Standard success response
     */
    protected function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Standard error response
     */
    protected function errorResponse(string $message = 'Error occurred', int $code = 500, $data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Handle exceptions with proper logging
     */
    protected function handleException(Exception $e, string $context = 'Controller'): JsonResponse
    {
        Log::error("{$context} Error: " . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return $this->errorResponse(
            'An error occurred while processing your request',
            500
        );
    }

    /**
     * Standard redirect with success message
     */
    protected function redirectWithSuccess(string $route, string $message = 'Operation completed successfully'): RedirectResponse
    {
        return redirect()->route($route, app()->getLocale())
            ->with('success', $message);
    }

    /**
     * Standard redirect with error message
     */
    protected function redirectWithError(string $route, string $message = 'An error occurred'): RedirectResponse
    {
        return redirect()->route($route, app()->getLocale())
            ->with('error', $message);
    }

    /**
     * Execute operation with try-catch wrapper
     */
    protected function executeOperation(callable $operation, string $context = 'Operation'): JsonResponse|RedirectResponse
    {
        try {
            return $operation();
        } catch (Exception $e) {
            return $this->handleException($e, $context);
        }
    }
}
