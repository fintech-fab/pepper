<?php

Route::get('/', function () {
    return '';
});

Route::post('/slack', 'SlackController@index');