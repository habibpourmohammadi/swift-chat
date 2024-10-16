<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class DeleteMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $username;

    public $isLastMessage;

    public $chatUuid;

    /**
 * Constructor for initializing the class properties.
     */
    public function __construct($username, $isLastMessage, $chatUuid)
    {
        $this->username = $username;
        $this->isLastMessage = $isLastMessage;
        $this->chatUuid = $chatUuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chat.member.' . $this->username),
            new PresenceChannel('chat.member.' . Auth::user()->username),
        ];
    }
}
