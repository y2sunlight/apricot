<?php
namespace Apricot\Foundation;

/**
 * Request ActionInvoker Class
 */
class ActionInvoker implements Invoker
{
    /**
     * Controller name
     * @var string;
     */
    private $controller;

    /**
     * method name
     * @var string
     */
    private $action;

    /**
     * parameters
     * @var array
     */
    private $params;

    /**
     * Create ActionInvoker
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
     * Invoke action
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