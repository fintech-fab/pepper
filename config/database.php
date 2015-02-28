<?php

return [

    'fetch'       => PDO::FETCH_CLASS,
    'default'     => 'mongodb',
    'connections' => [

        'mongodb' => array(
            'driver'   => 'mongodb',
            'host'     => 'localhost',
            'port'     => 27017,
            'username' => env('MONGO_USER'),
            'password' => env('MONGO_PASSWORD'),
            'database' => env('MONGO_DATABASE'),
        ),

    ],

    'migrations'  => 'migrations',

];
