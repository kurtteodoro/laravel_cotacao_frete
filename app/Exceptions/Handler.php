<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
            //
        });
    }

    /**
     * Handle exception rendering.
     */
    public function render($request, Throwable $exception)
    {
        // Verifica se é uma exceção de validação
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422, [], JSON_UNESCAPED_UNICODE); // Aplica a flag JSON_UNESCAPED_UNICODE
        }

        // Mantém o comportamento padrão para outras exceções
        return parent::render($request, $exception);
    }
}
