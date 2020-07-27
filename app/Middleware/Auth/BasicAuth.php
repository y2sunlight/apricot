<?php
namespace App\Middleware\Auth;

use Apricot\Foundation\Response;
use Apricot\Foundation\Invoker;
use Apricot\Foundation\Middleware\Middleware;
use App\Foundation\Security\AuthUser;

/**
 * Middleware - Basic authentication
 */
class BasicAuth implements Middleware
{
    /**
     * @var array List of controllers to exclude
     */
    private $exclude = [
    ];

    /**
     * {@inheritDoc}
     * @see \Apricot\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        // When excluded controller.
        if (in_array(controllerName(), $this->exclude))
        {
            return $next->invoke();
        }

        // Verifies whether user is authenticated.
        if (AuthUser::verify())
        {
            return $next->invoke();
        }

        // Authenticates
        if (array_key_exists('PHP_AUTH_USER', $_SERVER) && array_key_exists('PHP_AUTH_PW',$_SERVER))
        {
            if (AuthUser::authenticate($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']))
            {
                return $next->invoke();
            }
        }

        // Sends '401 Unauthorized' to client if not authorized.
        $response = render('error.basic_auth', ['message'=>__('auth.basic.msg_needed_login')])
        ->addHeader("HTTP/1.0 401 Unauthorized")
        ->addHeader('WWW-Authenticate: Basic realm="Enter username and password."');
        return $response;
    }
}