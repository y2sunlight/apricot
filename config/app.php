<?php
return
[
    'setup' =>[
        config_dir('setup/whoops.setup.php'),    /* Error handler(whoops) */
        config_dir('setup/bladeone.setup.php'),  /* View template (BladeOne) */
        config_dir('setup/aliases.setup.php'),   /* Class aliases for view template and so on */
        config_dir('setup/idiorm.setup.php'),    /* ORM(idiorm) */
        config_dir('setup/validator.setup.php'), /* Valitron\Validator */
    ],
    'middleware' =>[
        \App\Middleware\AccessLog::class,        /* Access log */
        \App\Middleware\VerifyCsrfToken::class,  /* Verify CSRF Token */
//      \App\Middleware\Auth\BasicAuth::class,   /* Basic Auth. */
        \App\Middleware\Auth\SessionAuth::class, /* Session Auth. */
    ],
    'csrf' =>[
        'disposable' => false,
    ],
    'auth' =>[
        'db'=>[
            'user'=>[
                'account' =>'account',
                'password' =>'password',
                'remember' =>'remember_token',
            ],
        ],
        'expires_sec'=> 2*7*24*3600, /* 2weekws */
        'menu'=> true,
    ],
];