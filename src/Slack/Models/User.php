<?php


namespace FintechFab\Pepper\Slack\Models;

use Moloquent;

/**
 * Class User
 *
 * @property string      $name
 * @property string      $slack_id
 * @property UserRedmine redmine
 *
 * @method static User truncate()
 * @method static User where($field, $value)
 * @method static User first()
 * @method static User whereSlackId($slack_id)
 *
 *
 * @package FintechFab\Pepper\Slack\Models
 */
class User extends Moloquent
{

    protected $connection = 'mongodb';
    protected $collection = 'users';


    /**
     * @return UserRedmine
     */
    public function redmine()
    {
        return $this->embedsOne(UserRedmine::class);
    }

}