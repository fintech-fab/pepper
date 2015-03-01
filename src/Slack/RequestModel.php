<?php


namespace FintechFab\Pepper\Slack;

/**
 * Class RequestModel
 *
 * @property string $text
 * @property string $team_id
 * @property string $channel_id
 * @property string $channel_name
 * @property string $timestamp
 * @property string $user_id
 * @property string $user_name
 * @property string $trigger
 *
 * @package FintechFab\Pepper\Slack\Request
 */
class RequestModel
{


    private $data;
    public $trigger;

    public function __construct($data)
    {
        $this->data = $data;
        $this->trigger = !empty($data['trigger_word'])
            ? $data['trigger_word']
            : explode(' ', $data['text'])[0];
    }

    public function __get($name)
    {
        return isset($this->data[$name])
            ? $this->data[$name]
            : null;
    }

    public function getPublicData()
    {
        return [
            'user_id'      => $this->user_id,
            'user_name'    => $this->user_name,
            'channel_name' => $this->channel_name,
            'channel_id'   => $this->channel_id,
        ];
    }

}