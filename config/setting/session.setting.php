<?php
/**
 * This file contains session settings.
 */
return
[
    'name' => 'SID'.substr(md5(env('APP_SECRET', env('APP_NAME'))),0,16),
    'ini' =>[
        'gc_maxlifetime' => null,   /* default: 1440[sec] */
        'gc_probability' => null,   /* default: 1         */
        'gc_divisor' => null,       /* default: 100       */
        'cookie_lifetime' => null,  /* default: 0[sec]    */
    ],
];