<?php
/**
 * initial settings of Error handler (Whoops)
 */
return function():bool
{
    $whoops = new \Whoops\Run;
    if(config('whoops.debug'))
    {
        //----------------------------
        // Error handler for debugging
        //----------------------------
        $whoops->pushHandler(new Apricot\Derivations\PrettyErrorHandlerWithLogger);
    }
    else
    {
        //----------------------------
        // Error handler for production
        //----------------------------
        $whoops->pushHandler(function($exception, $inspector, $run)
        {
            // Output error log
            Apricot\Log::critical($exception->getMessage(),[$exception->getFile(),$exception->getLine(), $exception->getTraceAsString()]);

            // Display error screen for users
            // TODO: Here I have to suppress the exception loop
            $controller = config('whoops.controller',null);
            $action = config('whoops.action',null);
            if (isset($controller)&&isset($action))
            {
                $instance = new $controller();
                $response = call_user_func_array(array($instance, $action), [$exception]);
            }
            return \Whoops\Handler\Handler::QUIT;
        });
    }

    $whoops->register();
    return true; // Must return true on success
};