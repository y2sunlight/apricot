<?php
namespace App\Middleware;

use Apricot\Foundation\Response;
use Apricot\Foundation\Invoker;
use Apricot\Foundation\Middleware\Middleware;
use Apricot\Foundation\Security\CsrfToken;

/**
 * CSRFトークンの検証 - Middleware
 */
class VerifyCsrfToken implements Middleware
{
    /**
     * Excludeing controller
     * @var array
     */
    private $exclude = [
        'HogeHogeController', // For example: Web API controller etc.
    ];

    /**
     * Process incoming requests and produces a response
     * {@inheritDoc}
     * @see \Apricot\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        if (!in_array(controllerName(), $this->exclude))
        {
            // CSRFトークンの検証を行う
            if (!CsrfToken::verify())
            {
                throw new \Apricot\Exceptions\TokenMismatchException('VerifyCsrfToken Error');
            }
        }

        // CSRFトークンを生成する
        CsrfToken::generate();

        return $next->invoke();
    }
}