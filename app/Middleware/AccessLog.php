<?php
namespace App\Middleware;

use Core\Log;
use Core\Input;
use Core\Foundation\Response;
use Core\Foundation\Invoker;
use Core\Foundation\Middleware\Middleware;

/**
 * アクセスログ - Middleware
 */
class AccessLog implements Middleware
{
    /**
     * Process incoming requests and produces a response
     * {@inheritDoc}
     * @see \Core\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        $message = session_id().' '.$_SERVER['REQUEST_METHOD'].' '.$_SERVER['REQUEST_URI'];

        // 前処理
        $data = [
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'remote_user' => array_key_exists('REMOTE_USER', $_SERVER) ?$_SERVER['REMOTE_USER'] : 'Anonymous',
            'user_agent' =>  $_SERVER['HTTP_USER_AGENT'],
            'input' => json_encode(Input::all()),
        ];
        Log::info("$message",$data);

        // 次のInvokerを呼び出す
        return $next->invoke();
    }
}