<?php

namespace App\Events;

use Illuminate\Broadcasting\{Channel, PrivateChannel, PresenceChannel, InteractsWithSockets};
use Illuminate\{Queue\SerializesModels, Foundation\Events\Dispatchable, Contracts\Broadcasting\ShouldBroadcast};

class SayWelcomeToNewUserEvent
{
    /* `Dispatchable` allows you to dispatch this event */
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
