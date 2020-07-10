<?php
namespace App\Middleware\Auth;

use Core\Foundation\Response;
use Core\Foundation\Invoker;
use Core\Foundation\Middleware\Middleware;
use App\Foundation\Security\AuthUser;

/**
 * Session認証 - Middleware
 */
class SessionAuth implements Middleware
{
    /**
     * Excludeing controller
     * @var array
     */
    private $exclude = [
        'AuthController',
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

        // 未認証の場合は、ログイン画面を表示
        return redirect(route('login'));
    }
}