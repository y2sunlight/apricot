<?php
namespace Apricot\Foundation\Middleware;

use Apricot\Foundation\Invoker;
use Apricot\Foundation\Response;

/**
 * Middleware Invoker
 */
class MiddlewareInvoker implements Invoker
{
    /**
     * @var Middleware Middleware instance
     */
    private $middleware;

    /**
     * @var Invoker Next invoker instance
     */
    private $nextInvoker;

    /**
     * Creates a middleware invoker.
     *
     * @param Middleware $middleware
     * @param Invoker $nextInvoker
     */
    public function __construct(Middleware $middleware, Invoker $nextInvoker)
    {
        $this->middleware = $middleware;
        $this->nextInvoker = $nextInvoker;
    }

    /**
     * Invokes middleware.
     *
     * {@inheritDoc}
     * @see \Apricot\Foundation\Invoker::invoke()
     */
    public function invoke(): Response
    {
        return $this->middleware->process($this->nextInvoker);
    }
}