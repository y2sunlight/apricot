<?php
namespace Core\Foundation\Middleware;

use Core\Foundation\Invoker;
use Core\Foundation\Response;

/**
 * Middleware Invoker
 */
class MiddlewareInvoker implements Invoker
{
    /**
     * Middleware Instance
     * @var Middleware
     */
    private $middleware;

    /**
     * Next Invoker Instance
     * @var Invoker
     */
    private $nextInvoker;

    /**
     * Create Middleware Handler
     * @param Middleware $middleware
     * @param Invoker $nextInvoker
     */
    public function __construct(Middleware $middleware, Invoker $nextInvoker)
    {
        $this->middleware = $middleware;
        $this->nextInvoker = $nextInvoker;
    }

    /**
     * Invoke middleware
     * @return \Core\Foundation\Response
     * {@inheritDoc}
     * @see \Core\Foundation\Invoker::invoke()
     */
    public function invoke(): Response
    {
        return $this->middleware->process($this->nextInvoker);
    }
}