<?php


namespace FintechFab\Pepper\Slack\Models;

use Moloquent;

/**
 * Class User
 *
 * @method static User truncate()
 * @method static User where($field, $value)
 * @method static User first()
 *
 * @package FintechFab\Pepper\Slack\Models
 */
class User extends Moloquent
{

    protected $connection = 'mongodb';
    protected $collection = 'users';

}