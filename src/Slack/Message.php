<?php


namespace FintechFab\Pepper\Slack;


use Config;
use Log;

class Message
{

    private $message = [];

    /**
     * @param null|string $text
     *
     * @return Message
     */
    public static function create($text = null)
    {
        $message = new self();
        if ($text) {
            $message->text($text);
        }

        return $message;
    }

    /**
     * @param $text
     *
     * @return Message
     */
    public function text($text)
    {
        $this->message['text'] = $text;

        return $this;
    }

    /**
     * @param MessageAttachment $attachment
     *
     * @return Message
     */
    public function attach(MessageAttachment $attachment)
    {
        if (!isset($this->message['attachments'])) {
            $this->message['attachments'] = [];
        }
        $this->message['attachments'][] = $attachment->toArray();

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->message;
    }


    /**
     * Отправить сообщение в канал
     *
     * @param string $channel
     *
     * @return mixed
     */
    public function send2Channel($channel)
    {
        $this->message['channel'] = '#' . trim($channel, '#');

        return $this->send();
    }

    /**
     * Отправить сообщение человеку
     *
     * @param string $username
     *
     * @return mixed
     */
    public function send2User($username)
    {
        $this->message['channel'] = '@' . trim($username, '@');

        return $this->send();
    }

    /**
     * Отправить сообщение
     */
    private function send()
    {
        $url = Config::get('slack.incoming.url');
        $data = 'payload=' . json_encode($this->message);

        Log::debug('message to slack', [$data]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        Log::debug('send slack message result', [$result]);

        return $result;

    }

}