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
     * Invokes an action.
     *
     * {@inheritDoc}
     * @see \Apricot\Foundation\Invoker::invoke()
     */
    public function invoke() : Response
    {
        // Enable auto wiring.
        $container = new \League\Container\Container;
        $container->delegate(new \League\Container\ReflectionContainer);

        // Gets a controller instance.
        $instance = $container->get("\\App\\Controllers\\{$this->controller}");

        // Sorts parameters so names match.
        $actionParams = array();
        $param_keys = array_keys($this->params);

        $reflection = new \ReflectionMethod($instance, $this->action);
        foreach($reflection->getParameters() AS $arg)
        {
            if(in_array($arg->name, $param_keys))
            {
                $actionParams[] = $this->params[$arg->name];
            }
        }

        // Calls $instance->invokeAction($this->action, $actionParams).
        return call_user_func_array(array($instance, 'invokeAction'), [$this->action, $actionParams]);
    }
}