<?php
namespace Apricot\Foundation;

/**
 * Request Controller Class (Controller Base)
 */
class BaseController
{
    /**
     * @var array The interceptors registered on the controller.
     */
    protected $interceptors = [];

    /**
     * Registers interceptors on the controller.
     *
     * @param  string $actionName
     * @param  array|mixed $interceptors array or arguments list
     */
    protected function intercept($actionName, $interceptors)
    {
        if ($actionName == \Apricot\Application::getInstance()->getActionName())
        {
            $interceptor_arr = is_array($interceptors) ? $interceptors : array_slice(func_get_args(),1);
            $this->interceptors = array_merge($this->interceptors , $interceptor_arr);
        }
    }

    /**
     * Calls a real Action.
     *
     * @param string $actionName
     * @param array $params
     * @return \Apricot\Foundation\Response
     */
    protected function callAction($actionName, $params)
    {
        return call_user_func_array(array($this, $actionName), $params);
    }

    /**
     * Invokes an Action.
     *
     * @param string $actionName
     * @param array $params
     * @return \Apricot\Foundation\Response
     */
    public function invokeAction($actionName, $params)
    {
        // Add a controller instance to parameters to invoke an interceptor.
        $iparams = array_merge(array('_controller'=>$this), $params);

        // Invokes interceptors.
        $response = null;
        foreach($this->interceptors as $interceptor)
        {
            if (is_callable($interceptor))
            {
                // Case of callable.
                $response = call_user_func_array($interceptor, $iparams);
            }
            elseif(strpos($interceptor,'@')!==false)
            {
                // Case of Controller/Action.
                list($class, $method) = explode('@', $interceptor);
                if (empty($class))
                {
                    $instance = $this;
                }
                else
                {
                    $class = "\\App\\Controllers\\Interceptors\\{$class}";
                    $instance = new $class;
                }

                // Invokes an interceptor.
                $response = call_user_func_array(array($instance, $method), $iparams);
            }

            if ($response instanceof Response)
            {
                return $response;
            }
        }

        // Calls an Action.
        return $this->callAction($actionName, $params);
    }
}