<?php

namespace App\Livewire\Home;

use App\Models\Chat;
use App\Models\ChatMessage;
use Carbon\Carbon;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class ChatPage extends Component
{
    public Chat $chat;

    #[Locked]
    public $uuid;

    public function mount()
    {
        // Check if the authenticated user has access to the current chat using its UUID
        if (!Auth::user()->canSeeChat($this->chat->chat_uuid)) {
            // Redirect the user to the home page if they don't have access
            $this->redirectRoute("home.page", navigate: true);
        }

        // Set the component's UUID to the chat's UUID
        $this->uuid = $this->chat->chat_uuid;
    }

    #[Computed()]
    public function messages()
    {
        // Get all messages for the current chat
        return $this->chat->messages->chunkWhile(function ($current_message, $key, $chunk) {
            // Parse the creation dates of the current and previous messages
            $current_message_date = Carbon::parse($current_message->created_at);
            $previous_message_date = Carbon::parse($chunk->last()->created_at);

            // Group messages that were sent on the same day
            return $current_message_date->isSameDay($previous_message_date);
        })->all();
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

    public function createMessage($message)
    {
        // Check if the authenticated user can view or interact with the current chat
        if (!Auth::user()->canSeeChat($this->chat->chat_uuid)) {
            // Redirect the user to the home page if they don't have access
            $this->redirectRoute("home.page", navigate: true);
        }

        // Create a new message in the chat for the authenticated user
        $newMessage = ChatMessage::create([
            "chat_id" => $this->chat->id,
            "member_id" => Auth::user()->id,
            "message" => $message,
            "message_type" => "text",
        ]);

        // Return an array with the new message details
        return [
            "id" => $newMessage->id,
            "full_name" => Auth::user()->full_name,
            "avatar" => Auth::user()->avatar,
            "message" => $newMessage->message,
            "created_at" => jalaliDate($newMessage->created_at, "H:i"),
        ];
    }
}
