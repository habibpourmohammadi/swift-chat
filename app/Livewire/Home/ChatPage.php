<?php

namespace App\Livewire\Home;

use App\Models\Chat;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class ChatPage extends Component
{
    public Chat $chat;

    #[Computed()]
    public function messages()
    {
        // Get all messages for the current chat
        return $this->chat->messages;
    }

    #[Computed()]
    public function member()
    {
        // Get the chat member who is not the authenticated user
        return $this->chat->members()->where("user_id", "!=", Auth::user()->id)->first();
    }

    #[Computed()]
    public function chats()
    {
        // Return the authenticated user's chats
        return Auth::user()->chats();
    }
}
