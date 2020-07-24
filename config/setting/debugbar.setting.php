<?php
/**
 * This file contains DebugBer settings.
 */
return
[
    'debug' => env('APP_DEBUG',false),
    'renderer' => [
        'auto_assets'=>true,
        'base_url' => url('resources/debugbar'),
        'base_path' => public_dir('resources/debugbar'),
        'initialize' => true,
        'stacked_data' => true,
    ],
];
