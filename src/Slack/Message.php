<?php


namespace FintechFab\Pepper\Slack;


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

}