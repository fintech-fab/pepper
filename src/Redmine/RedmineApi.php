<?php


namespace FintechFab\Pepper\Redmine;

use Redmine\Client;

class RedmineApi
{

    /**
     * @var Client
     */
    private $api;

    public function __construct()
    {
        $this->api = app()->make('RedmineClient');
    }

    public function myLastIssues($user_id)
    {
        return $this->api->api('issue')->all([
            'limit'          => 200,
            'assigned_to_id' => $user_id,
        ])['issues'];
    }


    public function myId()
    {
        $user = $this->api->api('user')->getCurrentUser();

        return $user['user']['id'];
    }

}