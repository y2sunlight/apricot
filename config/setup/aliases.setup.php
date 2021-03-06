<?php
/**
 * Registers the class alias used in the view template
 */
return function():bool
{
    $aliases =
    [
        /* Apricot */
        'Input' => Apricot\Input::class,
        'QueryString' => Apricot\QueryString::class,
        'Session' => Apricot\Session::class,
        'Flash' => Apricot\Flash::class,
        'Cookie' => Apricot\Cookie::class,
        'Config' => Apricot\Config::class,
        'Log' => Apricot\Log::class,
        'Debug' => Apricot\Debug::class,
        'DebugBar' => Apricot\DebugBar::class,
        'ErrorBag' => Apricot\Foundation\ErrorBag::class,

        /* App */
        'ViewHelper' => App\Helpers\ViewHelper::class,
        'ValidatorErrorBag' => App\Foundation\ValidatorErrorBag::class,
        'Container' => App\Foundation\Container::class,
        'AuthUser' => App\Foundation\Security\AuthUser::class,
    ];

    // Creates an alias for a class
    foreach($aliases as $alias_name => $original_class)
    {
        class_alias($original_class, $alias_name);
    }
    return true; // Must return true on success
};
