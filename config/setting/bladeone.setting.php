<?php
/**
 * This file contains BladeOne settings.
 */
return
[
    'template_path' => env('VIEW_TEMPLATE',assets_dir('views')),
    'compile_path' => env('VIEW_CACHE',var_dir('cache/views')),
    'mode' => \eftec\bladeone\BladeOne::MODE_AUTO,
];
