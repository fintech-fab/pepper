<?php


namespace FintechFab\Pepper\Slack\Components;


use FintechFab\Pepper\Slack\Models\User;

class UserComponent
{

    public static function create($data)
    {
        User::unguard();
        User::create($data);
    }

}