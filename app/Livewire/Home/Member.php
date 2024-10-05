<?php

namespace App\Livewire\Home;

use App\Models\ChatMember;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Member extends Component
{
    public ChatMember $member;

    #[Computed()]
    public function latestMessage()
    {
        // Retrieve the latest message from the chat associated with the member
        return $this->member->chat->messages()->latest()->first();
    }

    /**
     * Redirects the user to the chat page for the current member's chat.
     */
    public function redirectToChatPage()
    {
        // Redirect to the chat page for this member's chat
        $this->redirectRoute("home.chat.page", [$this->member->chat], navigate: true);
    }
}
