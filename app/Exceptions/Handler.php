<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (Route::getCurrentRequest() && Route::getCurrentRequest()->is('api/*')) {

            if ($e instanceof ModelNotFoundException) {
                return rest_error_response(404, 'Resource not found');
            }

            $code = $e->getStatusCode();
            $message = $e->getMessage();

            if ($code == Response::HTTP_FORBIDDEN && $message == '') {
                $message = 'Access denied';
            }
            if ($code == Response::HTTP_NOT_FOUND && $message == '') {
                $message = 'Resource not found';
            }
            if ($code == Response::HTTP_METHOD_NOT_ALLOWED && $message == '') {
                $message = 'Method not allowed';
            }

            if ($e instanceof TokenInvalidException) {
                $code = Response::HTTP_UNAUTHORIZED;
                $message = 'Token is invalid';
            }

            if ($e instanceof TokenExpiredException) {
                $code = Response::HTTP_UNAUTHORIZED;
                $message = 'Token has expired';
            }

            return rest_error_response($code, $message);
        }

        return parent::render($request, $e);
    }
}
