<?php

namespace App\Exceptions;

use Response;
use Exception;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function(TokenInvalidException $e, $request){
                return Response::json([
                    'status' => false,
                    'error'  => 'Invalid token'
                ], 401);
        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return Response::json([
                'status' => false,
                'error'  => 'Token has Expired'
            ], 401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return Response::json([
                'status' => false,
                'error'  => 'Token not parsed'
            ], 401);
        });
    }
}
