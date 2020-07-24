<?php
namespace App\Middleware\Auth;

use Apricot\Foundation\Response;
use Apricot\Foundation\Invoker;
use Apricot\Foundation\Middleware\Middleware;
use App\Foundation\Security\AuthUser;

/**
 * Middleware - Session authentication
 */
class SessionAuth implements Middleware
{
    /**
     * @var array List of controllers to exclude
     */
    private $exclude = [
        'AuthController',
    ];

    /**
     * {@inheritDoc}
     * @see \Apricot\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        // When excluded controller
        if (in_array(controllerName(), $this->exclude))
        {
            return $next->invoke();
        }

        // Verify whether user is authenticated
        if (AuthUser::verify())
        {
            return $next->invoke();
        }

        // Redirect to login page If not authenticated.
        return redirect(route('login'));
    }
}