<?php
namespace App\Exceptions;

/**
 * Uncaught Exception Handler
 */
class UncaughtExceptionHandler
{
    /**
     * Render uncaught exception
     * @param \Throwable $exception
     */
    public function render(\Throwable $exception)
    {
        if ($exception instanceof \Core\Exceptions\TokenMismatchException)
        {
            // CSRFエラーなどのトークンエラーは419(Page Expired)
            $status_code = 419;
        }
        elseif ($exception instanceof \Core\Exceptions\HttpException)
        {
            $status_code = $exception->getStatusCode();
        }
        else
        {
            // その他のエラーは500(Internal Server Error)
            $status_code = 500;
        }

        // エラー画面を表示する
        render('error.exception', ['status_code'=>$status_code])->commit($status_code);
    }
}
