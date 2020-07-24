<?php
namespace Apricot\Foundation\Middleware;

use Apricot\Foundation\ActionInvoker;

/**
 * Middleware Pipeline Class
 */
class MiddlewarePipeline
{
    /**
     * @var Middleware[]
     */
    private $middleware = [];

    /**
     * Creates a Middleware pipeline.
     *
     * @param Middleware[] $middleware
     */
    public function __construct(array $middleware=[])
    {
        foreach($middleware as $item)
        {
            $this->addMiddleware(new $item);
        }
    }

    /**
     * Adds a middleware.
     *
     * @param Middleware $middleware
     */
    public function addMiddleware(Middleware $middleware)
    {
        array_unshift($this->middleware, $middleware);
        return $this;
    }

    /**
     * Executes an action.
     *
     * @param ActionInvoker $action
     * @return \Apricot\Foundation\Response
     */
    public function executeAction(ActionInvoker $invoker)
    {
        // Create Pipeline
        foreach($this->middleware as $middleware)
        {
            $invoker = new MiddlewareInvoker($middleware, $invoker);
        }

        return $invoker->invoke();
    }
}