<?php
//-------------------------------------------------------------------
// ビューテンプレートで使うクラスエイリアスを登録
//-------------------------------------------------------------------
return function():bool
{
    $aliases =
    [
        /* Core */
        'Input' => \Core\Input::class,
        'QueryString' => \Core\QueryString::class,
        'Session' => \Core\Session::class,
        'Flash' => \Core\Flash::class,
        'Cookie' => \Core\Cookie::class,
        'Config' => \Core\Config::class,
        'Log' => \Core\Log::class,
        'Debug' => \Core\Debug::class,
        'DebugBar' => \Core\DebugBar::class,
        'ErrorBag' => \Core\Foundation\ErrorBag::class,

        /* App */
        'ViewHelper' => \App\Helpers\ViewHelper::class,
        'ValidatorErrorBag' => \App\Foundation\ValidatorErrorBag::class,
        'AuthUser' => \App\Foundation\Security\AuthUser::class,
    ];

    // Creates an alias for a class
    foreach($aliases as $alias_name => $original_class)
    {
        class_alias($original_class, $alias_name);
    }
    return true; // Must return true on success
};
