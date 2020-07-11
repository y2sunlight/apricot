<?php
namespace Apricot\Foundation;

/**
 * Request Controller Class (Controller Base)
 */
class BaseController
{
    /**
     * The interceptors registered on the controller.
     * @var array
     */
    protected $interceptors = [];

    /**
     * Register interceptors on the controller.
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
     * Call real Action
     * @param string $actionName
     * @param array $params
     * @return \Apricot\Foundation\Response
     */
    protected function callAction($actionName, $params)
    {
        return call_user_func_array(array($this, $actionName), $params);
    }

    /**
     * Invoke Action
     * @param string $actionName
     * @param array $params
     * @return \Apricot\Foundation\Response
     */
    public function invokeAction($actionName, $params)
    {
        // Interceptor parameters
        $iparams = array_merge(array('_controller'=>$this), $params);

        // Invoke Interceptor
        $response = null;
        foreach($this->interceptors as $interceptor)
        {
            if (is_callable($interceptor))
            {
                // Case of callable
                $response = call_user_func_array($interceptor, $iparams);
            }
            elseif(strpos($interceptor,'@')!==false)
            {
                // Case of Controller/Action
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

                // Call interceptor
                $response = call_user_func_array(array($instance, $method), $iparams);
            }

            if ($response instanceof Response)
            {
                return $response;
            }
        }

        // Call Action
        return $this->callAction($actionName, $params);
    }
}