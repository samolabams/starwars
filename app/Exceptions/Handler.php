<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => [
                    'http_code' => 404,
                    'message' => 'The requested resource is not available',
                ]
            ], 404);
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => [
                    'http_code' => 405,
                    'message' => 'This method is not allowed on this endpoint',
                    'allowed_methods' => $exception->getHeaders()['Allow'],
                ]
            ], 405);
        } else {
            return response()->json([
                'error' => [
                    'http_code' => 500,
                    'message' => 'There is an Internal Server Error',
                ]
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
