<?php
return
[
    'name' => env('LOG_NAME',env('APP_NAME')),
    'path' => env('LOG_PATH',var_dir('logs')),
    'level'=> env('LOG_LEVEL','debug'),
    'max_files'=> 0,
];