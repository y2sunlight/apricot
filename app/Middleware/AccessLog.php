<?php
namespace App\Middleware;

use Apricot\Log;
use Apricot\Input;
use Apricot\Foundation\Response;
use Apricot\Foundation\Invoker;
use Apricot\Foundation\Middleware\Middleware;

/**
 * Access Log - Middleware
 */
class AccessLog implements Middleware
{
    /**
     * {@inheritDoc}
     * @see \Apricot\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        // Logs a message.
        $message = session_id().' '.$_SERVER['REQUEST_METHOD'].' '.$_SERVER['REQUEST_URI'];

        // Logs context data.
        $data = [
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'remote_user' => array_key_exists('REMOTE_USER', $_SERVER) ?$_SERVER['REMOTE_USER'] : 'Anonymous',
            'user_agent' =>  $_SERVER['HTTP_USER_AGENT'],
            'input' => json_encode(Input::all()),
        ];
        Log::info("$message",$data);

        // Calls the next Invoker.
        return $next->invoke();
    }
}