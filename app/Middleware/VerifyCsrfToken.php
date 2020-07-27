<?php
namespace App\Middleware;

use Apricot\Foundation\Response;
use Apricot\Foundation\Invoker;
use Apricot\Foundation\Middleware\Middleware;
use Apricot\Foundation\Security\CsrfToken;

/**
 * CSRF token verification - Middleware
 */
class VerifyCsrfToken implements Middleware
{
    /**
     * @var array List of controllers to exclude
     */
    private $exclude = [
        'HogeHogeController', // For example: Web API controller etc.
    ];

    /**
     * {@inheritDoc}
     * @see \Apricot\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        if (!in_array(controllerName(), $this->exclude))
        {
            // Verifies CSRF tokens.
            if (!CsrfToken::verify())
            {
                throw new \Apricot\Exceptions\TokenMismatchException('VerifyCsrfToken Error');
            }
        }

        // Generates a CSRF token.
        CsrfToken::generate();

        return $next->invoke();
    }
}