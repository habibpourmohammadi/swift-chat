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
}
