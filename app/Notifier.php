<?php

namespace App;

class Notifier
{
    private $slack;

    public function __construct(SlackClient $slack)
    {
        $this->slack  = $slack;
    }

    public function notifyAdmins($message)
    {
        $this->slack->send($message, 'admins');
    }
}
