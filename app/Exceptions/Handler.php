<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log critical errors
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                \Log::warning('Authentication failed', [
                    'user_id' => auth()->id(),
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'url' => request()->url()
                ]);
            }

            if ($e instanceof \Illuminate\Database\QueryException) {
                \Log::error('Database error', [
                    'query' => $e->getSql(),
                    'bindings' => $e->getBindings(),
                    'message' => $e->getMessage(),
                    'ip' => request()->ip()
                ]);
            }

            // Log SOS-related errors for admin alerts
            if (str_contains($e->getMessage(), 'sos') || str_contains($e->getMessage(), 'SOS')) {
                \Log::error('SOS system error', [
                    'error' => $e->getMessage(),
                    'user_id' => auth()->id(),
                    'ip' => request()->ip(),
                    'stack' => $e->getTraceAsString()
                ]);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Custom error responses for API requests
        if ($request->expectsJson()) {
            $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
            
            $response = [
                'error' => true,
                'message' => $this->getErrorMessage($exception),
                'code' => $statusCode
            ];

            // Add debug info in development
            if (app()->environment('local')) {
                $response['debug'] = [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString()
                ];
            }

            return response()->json($response, $statusCode);
        }

        // Custom error pages for web requests
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        switch ($statusCode) {
            case 403:
                return response()->view('errors.403', [], 403);
            case 404:
                return response()->view('errors.404', [], 404);
            case 419:
                return response()->view('errors.419', [], 419);
            case 429:
                return response()->view('errors.429', [], 429);
            case 500:
                return response()->view('errors.500', [], 500);
            default:
                return response()->view('errors.generic', [
                    'message' => $exception->getMessage(),
                    'statusCode' => $statusCode
                ], $statusCode);
        }
    }

    /**
     * Get user-friendly error messages
     */
    private function getErrorMessage(Throwable $exception): string
    {
        $message = $exception->getMessage();

        switch (get_class($exception)) {
            case \Illuminate\Auth\AuthenticationException::class:
                return 'Authentication required. Please log in to continue.';
            
            case \Illuminate\Auth\Access\AuthorizationException::class:
                return 'You do not have permission to perform this action.';
            
            case \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class:
                return 'The requested resource was not found.';
            
            case \Illuminate\Database\QueryException::class:
                return 'Database error occurred. Please try again later.';
            
            case \Illuminate\Validation\ValidationException::class:
                return 'The submitted data is invalid. Please check your input.';
            
            default:
                return app()->environment('local') 
                    ? $message 
                    : 'An unexpected error occurred. Please try again later.';
        }
    }
}
