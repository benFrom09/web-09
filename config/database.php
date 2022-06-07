<?php
return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'driver'    => environment('DB_DRIVER'),
            'port'      => environment('DB_PORT'),
            'host'      => environment('DB_HOST'),
            'database'  => environment('DB_NAME'),
            'username'  => environment('DB_USERNAME'),
            'password'  => environment('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ],
];