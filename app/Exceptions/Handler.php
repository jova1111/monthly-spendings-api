<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        error_log($exception);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json(['message' => $exception->getMessage()], 401);
        } else if ($exception instanceof JWTException) {
            return response()->json(['message' => 'Error while creating token.'], 500);
        } else if ($exception instanceof ResourceNotFoundException) {
            return response()->json(['message' => $exception->getMessage()], 404);
        } else if ($exception instanceof AuthorizationException) {
            return response()->json(['message' => 'User does not have permissions to execute given action.'], 403);
        } else if ($exception instanceof ResourceConflictException) {
            return response()->json(['message' => $exception->getMessage()], 409);
        } else if ($exception instanceof ValidationException) {
            $allErrors = $exception->errors();
            $firstError = reset($allErrors);
            return response()->json(['message' => reset($firstError)], 422);
        }
        return response()->json(['message' => $exception->getMessage()], 500);
    }
}
