<?php
/**
 * This file contains Idiorm settings.
 */
$now = date("Y-m-d H:i:s");
return
[
    'database'=>'sqlite',
    'caching' => true,
    'logging' => true,
    'connections' =>
    [
        'sqlite' => [
            'db_file' => var_dir('db/apricot.sqlite'),
            'connection_string' => 'sqlite:'.var_dir('db/apricot.sqlite'),
        ],
        'mysql' => [
            'connection_string' => 'mysql:host=localhost;port=3306;dbname=apricotdb',
            'username' => 'apricot',
            'password' => 'password',
            'check_tables' => 'show tables like \'user\'',
        ],
    ],
    'initial_data' => [
        'user'=> [
            'exec:sqlite' =>[
                'delete from sqlite_sequence where name=\'user\'',
            ],
            'exec:mysql' =>[
                'alter table user auto_increment = 1;',
            ],
            'rows' => [
                [
                    'account' =>'root',
                    'password' =>password_hash('', PASSWORD_DEFAULT),
                    'email' =>'root@sample.com',
                    'note' =>'Initial User',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ],
        ],
    ],
];
