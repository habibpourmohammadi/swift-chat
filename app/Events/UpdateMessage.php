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

class UpdateMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $newMessage;
    public string $memberUsername;
    public string $authorUsername;
    public string $chatUuid;
    public bool $isLastMessage;

    /**
     * Create a new event instance.
     */
    public function __construct(array $data)
    {
        $this->newMessage = $data["newMessage"];
        $this->memberUsername = $data["memberUsername"];
        $this->authorUsername = Auth::user()->username;
        $this->chatUuid = $data["chatUuid"];
        $this->isLastMessage = $data["isLastMessage"];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chat.member.' . $this->memberUsername),
            new PresenceChannel('chat.member.' . Auth::user()->username),
        ];
    }
}
