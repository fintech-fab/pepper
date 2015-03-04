<?php


namespace FintechFab\Pepper\Slack\Triggers;


use FintechFab\Pepper\Slack\Components\UserComponent;
use FintechFab\Pepper\Slack\Request;

class BaseTrigger
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $response;

    /**
     * @var array
     */
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

        if (!$this->response) {
            $this->response = '';
        }

        if (\Config::get('slack.trace')) {
            \Log::debug('slack trace trigger response', $this->response ? $this->response : []);
        }

        return $this->response;
    }


    public function param($num)
    {
        return isset($this->parameters[$num])
            ? $this->parameters[$num]
            : null;
    }

    public function fire()
    {

        if (\Config::get('slack.trace')) {
            \Log::debug('slack trace parameters', $this->parameters);
        }

    }

    /**
     * id автора сообщения
     *
     * @return string
     */
    public function getRequestUserName()
    {
        return $this->request->getUserName();
    }

}