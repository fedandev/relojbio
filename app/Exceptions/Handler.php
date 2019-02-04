<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Cookie;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
            
        if ($exception instanceof AuthorizationException){
            $minutes = 0.15;
            echo '<script> localStorage.setItem("alertaroja", "No esta autorizado a ejecutar la acción"); </script>';
            debug_to_console('Handler/AuthorizationException:');
	    
            return redirect()->route('main');
        }
        
        // if ($e instanceof \Illuminate\Session\TokenMismatchException) {    

        //     $minutes = 0.15;
        //     echo '<script> localStorage.setItem("alertaroja", "La sesión ha expirado"); </script>';
           
        // }
        if ($exception instanceof TokenMismatchException) {
            echo '<script> localStorage.setItem("alertaroja", "La sesión ha expirado"); </script>';
            return redirect()->route('main');
            
    	}
        return parent::render($request, $exception);
        
    }
}
