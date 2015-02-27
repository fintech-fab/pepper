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

        return $this;
    }

    public function trigger($trigger = null)
    {
        if (null === $trigger) {
            return $this->input->trigger;
        }

        return $this->input->trigger === $trigger;
    }


    public function getPublicData()
    {
        $result = $this->input->getPublicData();

        return $this->toFields($result);
    }

    public function toFields($a)
    {

        $fields = [];
        foreach ($a as $key => $value) {
            $fields[] = [
                'title' => $key,
                'value' => $value,
                'short' => false,
            ];
        }

        return $fields;
    }

}