<?php
return
[
    'debug' => env('APP_DEBUG',false),
    'controller' => \App\Exceptions\UncaughtExceptionHandler::class,
    'action' => 'render',
];
