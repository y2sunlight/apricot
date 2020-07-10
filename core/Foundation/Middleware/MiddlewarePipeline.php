<?php
namespace Core\Foundation\Middleware;

use Core\Foundation\ActionInvoker;

class MiddlewarePipeline
{
    /**
     * Middleware
     * @var Middleware[]
     */
    private $middleware = [];

    /**
     * Create
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
     * Add middleware
     * @param Middleware $middleware
     */
    public function addMiddleware(Middleware $middleware)
    {
        array_unshift($this->middleware, $middleware);
        return $this;
    }

    /**
     * Execute action
     * @param ActionInvoker $action
     * @return \Core\Foundation\Response
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