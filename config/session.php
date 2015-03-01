<?php

return [

    /*
    | Supported: "file", "cookie", "database", "apc", "memcached", "redis", "array"
    */

    'driver' => env('SESSION_DRIVER', 'array'),
    'lifetime'        => 120,
    'expire_on_close' => false,
    'encrypt'         => false,
    'files'           => storage_path() . '/framework/sessions',
    'connection'      => null,
    'table'           => 'sessions',
    'lottery'         => [2, 100],
    'cookie' => env('SESSION_COOKIE_NAME', 'peppers'),
    'path'            => '/',
    'domain'          => null,
    'secure'          => false,

];
