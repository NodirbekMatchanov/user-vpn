<?php

namespace app\helpers;

class PushMessage
{
    private $title;
    private $message;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return strip_tags($this->title);
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return strip_tags($this->message);
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
