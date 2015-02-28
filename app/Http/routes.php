<?php

Route::get('/', function () {
    return '';
});

Route::post('/slack', [
    'middleware' => 'slack',
    'uses'       => 'SlackController@index',
]);