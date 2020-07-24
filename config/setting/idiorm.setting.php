<?php
/**
 * This file contains Idiorm settings.
 */
return
[
    'sqlite' => [
        'db_file' => var_dir('db/apricot.sqlite'),
        'connection_string' => 'sqlite:'.var_dir('db/apricot.sqlite'),
        'caching' => true,
        'logging' => true,
    ],
    'initial_data' => [
        'user'=> [
            'exec' =>[
                'delete from sqlite_sequence where name=\'user\'',
            ],
            'rows' => [
                [
                    'account' =>'root',
                    'password' =>password_hash('', PASSWORD_DEFAULT),
                    'email' =>'root@sample.com',
                    'note' =>'Initial User',
                ],
            ],
        ],
    ],
];
