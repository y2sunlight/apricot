<?php
namespace App\Middleware\Auth;

use Core\Foundation\Response;
use Core\Foundation\Invoker;
use Core\Foundation\Middleware\Middleware;
use App\Foundation\Security\AuthUser;

/**
 * Basic認証 - Middleware
 */
class BasicAuth implements Middleware
{
    /**
     * Excludeing controller
     * @var array
     */
    private $exclude = [
    ];

    /**
     * Process incoming requests and produces a response
     * {@inheritDoc}
     * @see \Core\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        // When exclude controller
        if (in_array(controllerName(), $this->exclude))
        {
            return $next->invoke();
        }

        // Verify whether user is authenticated
        if (AuthUser::verify())
        {
            return $next->invoke();
        }

        // Basic認証
        if (array_key_exists('PHP_AUTH_USER', $_SERVER) && array_key_exists('PHP_AUTH_PW',$_SERVER))
        {
            if (AuthUser::authenticate($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']))
            {
                return $next->invoke();
            }
        }

        // 未認証の場合は '401 Unauthorized' をクライアントに送信
        $response = render('error.basic_auth', ['message'=>__('auth.basic.msg_needed_login')])
        ->addHeader("HTTP/1.0 401 Unauthorized")
        ->addHeader('WWW-Authenticate: Basic realm="Enter username and password."');
        return $response;
    }
}