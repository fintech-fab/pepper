<?php


namespace FintechFab\Pepper\Slack\Triggers;


use FintechFab\Pepper\Slack\Components\UserComponent;
use FintechFab\Pepper\Slack\Request;

class BaseTrigger
{

    private $request;
    private $response;

    protected $parameters;

    /**
     * @var UserComponent
     */
    protected $user;

    public function __construct(Request $request)
    {

        $this->request = $request;
        $this->parameters = $this->request->getParameters();
        $this->user = UserComponent::instance()->initBySlackId($this->request->getSlackId());

    }

    public function setResponse($data)
    {
        $this->response = $data;
    }

    public function response()
    {
        return $this->response;
    }


    public function param($num)
    {
        return isset($this->parameters[$num])
            ? $this->parameters[$num]
            : null;
    }

}