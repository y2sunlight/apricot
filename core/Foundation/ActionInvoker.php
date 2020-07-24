<?php
namespace Apricot\Foundation;

/**
 * Request Action Invoker Class
 */
class ActionInvoker implements Invoker
{
    /**
     * @var string Controller name
     */
    private $controller;

    /**
     * @var string action(method) name
     */
    private $action;

    /**
     * @var array parameters
     */
    private $params;

    /**
     * Creates an action invoker.
     *
     * @param string $controller
     * @param string $action
     * @param array $params
     */
    public function __construct(string $controller, string $action, array $params=[])
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
    }

    /**
     * Invokes the action.
     *
     * {@inheritDoc}
     * @see \Apricot\Foundation\Invoker::invoke()
     */
    public function invoke() : Response
    {
        // Enable auto wiring
        $container = new \League\Container\Container;
        $container->delegate(new \League\Container\ReflectionContainer);

        // Get controller instance
        $instance = $container->get("\\App\\Controllers\\{$this->controller}");

        return call_user_func_array(array($instance, 'invokeAction'), [$this->action, $this->params]);
    }
}