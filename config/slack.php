<?php

return [

    'token' => env('SLACK_TOKEN'),

    'users' => [
        'admin'   => env('SLACK_USER_ADMIN_ID'),
        'enabled' => env('SLACK_USER_ID_LIST'),
    ],

];