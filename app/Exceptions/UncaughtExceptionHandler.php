<?php
namespace App\Exceptions;

/**
 * Uncaught Exception Handler
 */
class UncaughtExceptionHandler
{
    /**
     * This method renders when an uncaught exception occurs.
     *
     * @param \Throwable $exception
     */
    public function render(\Throwable $exception)
    {
        if ($exception instanceof \Apricot\Exceptions\TokenMismatchException)
        {
            // For token errors such as CSRF errors, the status code is set to 419 (page expired).
            $status_code = 419;
        }
        elseif ($exception instanceof \Apricot\Exceptions\HttpException)
        {
            $status_code = $exception->getStatusCode();
        }
        else
        {
            // For any other error, the status code is set to 500 (internal server error).
            $status_code = 500;
        }

        // Render the error page.
        render('error.exception', ['status_code'=>$status_code])->commit($status_code);
    }
}
