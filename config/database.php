<?php

return [

    'fetch'       => PDO::FETCH_CLASS,
    'default'     => 'mongodb',
    'connections' => [

        'mongodb' => array(
            'driver'   => 'mongodb',
            'host'     => env('MONGO_HOST', 'localhost'),
            'port'     => env('MONGO_PORT', 27017),
            'username' => env('MONGO_USER', ''),
            'password' => env('MONGO_PASSWORD', ''),
            'database' => env('MONGO_DATABASE', 'pepper'),
        ),

    ],

    'migrations'  => 'migrations',

];
