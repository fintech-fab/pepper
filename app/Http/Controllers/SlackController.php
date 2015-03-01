<?php


namespace App\Http\Controllers;


use FintechFab\Pepper\Slack\Components\UserComponent;
use FintechFab\Pepper\Slack\Message;
use FintechFab\Pepper\Slack\MessageAttachment;
use FintechFab\Pepper\Slack\Request;
use FintechFab\Pepper\Slack\Triggers\Redmine;
use Response;

class SlackController extends Controller
{

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request->init();
    }

    public function index()
    {


        switch ($this->request->trigger()) {

            case 'help':
                /** @noinspection PhpIncludeInspection */
                return Response::make(require(app_path('/../static/help.md')));
                break;


            case 'touch':
                return $this->touch();
                break;


            case 'redmine':
                $trigger = new Redmine($this->request);
                $trigger->fire();

                return $this->response($trigger->response());
                break;

        }

        return '';

    }

    private function response($data)
    {

        if (\Config::get('slack.trace')) {
            \Log::debug('slack trace controller response', $data ? $data : []);
        }

        return Response::json($data);
    }

    private function touch()
    {

        UserComponent::create([
            'slack_id' => $this->request->getSlackId(),
            'name'     => $this->request->getUserName(),
        ]);

        $message = Message::create()
            ->text('Познай самого себя')
            ->attach(
                MessageAttachment::create()->fields($this->request->getPublicData())
            )->toArray();

        return $this->response($message);
    }

}