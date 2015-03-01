<?php


namespace FintechFab\Pepper\Slack\Triggers;

use Config;
use FintechFab\Pepper\Redmine\RedmineApi;
use FintechFab\Pepper\Slack\Message;
use FintechFab\Pepper\Slack\MessageAttachment;

class Redmine extends BaseTrigger
{

    public function fire()
    {
        parent::fire();

        switch ($this->param(0)) {

            case 'set.key':
                $this->user->setRedmineKey($this->param(1));
                break;

            case 'issues':
                $this->issues();
                break;

        }


    }

    private function issues()
    {
        $redmine = $this->user->get()->redmine;

        /** @var RedmineApi $api */
        $api = app()->make('RedmineApi');
        $issues = $api->myLastIssues($redmine->user_id);

        $message = new Message();
        $message->text('Мои задачи');

        foreach ($issues as $item) {
            $message->attach(
                MessageAttachment::create()
                    ->title('#' . $item['id'] . ' ' . $item['subject'])
                    ->link($this->issueUrl($item['id']))
                    ->fields(
                        [
                            'Проект'    => $item['project']['name'],
                            'Автор'     => $item['author']['name'],
                            'Статус'    => $item['status']['name'],
                            'Обновлена' => date('Y-m-d', strtotime($item['updated_on'])),
                        ]
                    )
            );
        }

        $this->setResponse($message->toArray());

    }

    private function issueUrl($id)
    {
        return Config::get('redmine.url') . 'issues/' . $id;
    }

}