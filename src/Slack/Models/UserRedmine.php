<?php


namespace FintechFab\Pepper\Slack\Models;

use Moloquent;

/**
 * Class User
 *
 * @property string $key
 * @property string $user_id
 *
 * @package FintechFab\Pepper\Slack\Models
 */
class UserRedmine extends Moloquent
{

    protected $connection = 'mongodb';

}