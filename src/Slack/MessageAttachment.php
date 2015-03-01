<?php


namespace FintechFab\Pepper\Slack;


class MessageAttachment
{

    private $attachment;

    /**
     * @param null|string $title
     *
     * @return MessageAttachment
     */
    public static function create($title = null)
    {
        $attachment = new self();
        if ($title) {
            $attachment->title($title);
        }

        return $attachment;
    }

    /**
     * @param string $title
     *
     * @return MessageAttachment
     */
    public function title($title)
    {
        $this->attachment['title'] = $title;

        return $this;
    }

    /**
     * @param string $link
     *
     * @return MessageAttachment
     */
    public function link($link)
    {
        $this->attachment['title_link'] = $link;

        return $this;
    }

    public function toArray()
    {
        return $this->attachment;
    }

    /**
     * @param array $fields
     *
     * @param bool $short
     *
     * @return MessageAttachment
     */
    public function fields($fields, $short = true)
    {

        $this->attachment['fields'] = [];
        foreach ($fields as $key => $value) {
            $this->attachment['fields'][] = [
                'title' => $key,
                'value' => $value,
                'short' => $short,
            ];
        }

        return $this;

    }

}