<?php
return
[
    'debug' => env('APP_DEBUG',false),
    'renderer' => [
        'base_url' => url('resources/debugbar'),
        'base_path' => public_dir('resources/debugbar'),
        'initialize' => true,
        'stacked_data' => true,
    ],
];
