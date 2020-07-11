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
     * @return \Apricot\Foundation\Response
     * {@inheritDoc}
     * @see \Apricot\Foundation\Invoker::invoke()
     */
    public function invoke(): Response
    {
        return $this->middleware->process($this->nextInvoker);
    }
}