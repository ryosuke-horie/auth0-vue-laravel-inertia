<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
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
     * Prepare exception for rendering.
     *
     * @param  \Throwable  $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        $response = parent::render($request, $e);

        // エラー時のステータスコード
        $statusCode = $response->getStatusCode();

        // 404エラーの場合
        if ($statusCode === 404) {
            return Inertia::render('Web/NotFound', ['status' => $statusCode])->toResponse($request)->setStatusCode($statusCode);
        }

        return $response;
    }
}
