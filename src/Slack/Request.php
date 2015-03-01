<?php
namespace FintechFab\Pepper\Slack;

use Input;

class Request
{

    /**
     * @var RequestModel
     */
    private $input;

    public function init()
    {
        $input = Input::all();
        $input = array_map('trim', $input);
        $this->input = new RequestModel($input);

        if (\Config::get('slack.trace')) {
            \Log::debug('slack trace input', $input);
        }

        return $this;
    }

    public function trigger($trigger = null)
    {
        if (null === $trigger) {
            return $this->input->trigger;
        }

        return $this->input->trigger === $trigger;
    }

    public function param($name)
    {
        return $this->input->$name;
    }

    public function getParameters()
    {
        $text = $this->input->text;
        $text = explode(' ', $text);
        unset($text[0]);

        return array_values($text);
    }

    public function getSlackId()
    {
        return $this->input->user_id;
    }


    public function getUserName()
    {
        return $this->input->user_name;
    }

    public function getPublicData()
    {
        return $this->input->getPublicData();
    }

}