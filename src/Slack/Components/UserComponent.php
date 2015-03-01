<?php


namespace FintechFab\Pepper\Slack\Components;


use FintechFab\Pepper\Redmine\RedmineApi;
use FintechFab\Pepper\Slack\Models\User;

class UserComponent
{

    /**
     * @var User
     */
    private $user;

    private static $instance;

    /**
     * @param array $data
     *
     * @return UserComponent
     */
    public static function create($data)
    {
        User::unguard();
        $user = User::create($data);
        $component = new self();
        $component->initByModel($user);

        return $component;
    }

    /**
     * @return UserComponent
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $sid
     *
     * @return UserComponent
     */
    public function initBySlackId($sid)
    {
        $this->user = User::whereSlackId($sid)->first();

        return $this;
    }

    /**
     * @param User $user
     *
     * @return UserComponent
     */
    public function initByModel(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function get()
    {
        return $this->user;
    }

    /**
     * ключ к api redmine
     *
     * @param string $key
     */
    public function setRedmineKey($key)
    {
        $this->initRedmine();

        $this->user->redmine->key = $key;

        /** @var RedmineApi $redmineApi */
        $redmineApi = app()->make('RedmineApi');
        $this->user->redmine->user_id = $redmineApi->myId();

        $this->user->redmine->save();
    }

    private function initRedmine()
    {
        if (!$this->user->redmine) {
            $this->user->redmine()->create([]);
        }
    }

    /**
     * @param string $id
     *
     * @return UserComponent
     */
    public function initById($id)
    {
        $this->user = User::find($id);

        return $this;
    }

}