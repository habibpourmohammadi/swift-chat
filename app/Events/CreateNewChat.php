<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CreateNewChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $username;
    public string $newMemberUsername;

    /**
     *  Constructor to initialize the event with the requested user's username and the username of the authenticated user.
     */
    public function __construct(string $username)
    {
        //  requested user's username
        $this->username = $username;
        //  the username of the authenticated user
        $this->newMemberUsername = Auth::user()->username;
    }

    /**
     * Specify the broadcasting channels the event should be sent to.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast the event on the user's specific presence channel
        return [
            new PresenceChannel('chat.member.' . $this->username),
        ];
    }
}
