<?php

namespace App\Livewire\Home;

use App\Events\DeleteMessage;
use App\Events\UpdateMessage;
use App\Models\Chat;
use App\Models\ChatMessage;
use Carbon\Carbon;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class ChatPage extends Component
{
    public $search = "";

    public Chat $chat;

    public $editingMessage;

    public $newMessageContent;

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

        $this->editingMessage = "";
        $this->newMessageContent = "";
    }

    public function updatedEditingMessage()
    {
        // Find the message being edited by its ID
        $message = ChatMessage::find($this->editingMessage);

        // Check if the message exists and if it belongs to the authenticated user
        if ($message === null || $message->member->user->id != Auth::user()->id) {
            // Reset the editing message and content if the user doesn't have permission
            $this->editingMessage = "";
            $this->newMessageContent = "";
        } else {
            // Set the message content for editing
            $this->newMessageContent = $message->message;
        }
    }

    public function updateMessage()
    {
        // Find the message being edited by its ID
        $message = ChatMessage::find($this->editingMessage);

        // Ensure the message exists, belongs to the authenticated user, is part of the correct chat, and the new content is not empty
        if ($message != null && $message->member->user->id === Auth::user()->id && $message->chat->chat_uuid == $this->uuid && $this->newMessageContent != "") {
            // Update the message content
            $message->update([
                "message" => $this->newMessageContent
            ]);

            // Prepare data for broadcasting the update
            $data = [
                "newMessage" => $message->message,
                "memberUsername" => $this->member()->user->username,
                "chatUuid" => $this->uuid,
                "isLastMessage" => false
            ];

            // Check if the updated message is the last message in the chat
            $lastMessage = ChatMessage::where("chat_id", $this->chat->id)->latest()->first();
            if ($lastMessage->id === $message->id) {
                $data["isLastMessage"] = true;
            }

            // Broadcast the message update
            broadcast(new UpdateMessage($data));
        }

        // Reset editing message and new message content fields
        $this->editingMessage = "";
        $this->newMessageContent = "";
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

    #[On("update-chat-list")]
    #[Computed()]
    public function chats()
    {
        // Return the authenticated user's chats
        return Auth::user()->chats($this->search);
    }

    public function createMessage($message)
    {
        // Check if the authenticated user can view or interact with the current chat
        if (!Auth::user()->canSeeChat($this->chat->chat_uuid)) {
            // Redirect the user to the home page if they don't have access
            $this->redirectRoute("home.page", navigate: true);
        }

        // Get member ID for Authenticated user
        $currentUserMemberId = $this->chat->members()->where("user_id", "=", Auth::user()->id)->first()->id;

        // Create a new message in the chat for the authenticated user
        $newMessage = ChatMessage::create([
            "chat_id" => $this->chat->id,
            "member_id" => $currentUserMemberId,
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

    /**
     * Delete a chat message by its ID and broadcast the event.
     */
    public function deleteMessage($messageId)
    {
        // Find the message by its ID
        $message = ChatMessage::find($messageId);

        if ($message) {
            // Check if the user is part of the chat and has the permission to delete the message
            $canDeleted = $message->chat->members()->where("user_id", Auth::user()->id)->first();

            // Verify the message belongs to the current chat and the user is authorized
            if ($message->chat->chat_uuid === $this->uuid && $message->chat && $canDeleted) {
                // Delete the message
                $message->delete();

                // Get the latest message after deletion
                $lastMessage = ChatMessage::where("chat_id", $this->member()->chat->id)->get()->last();
                $isLatestMessage = $lastMessage ? ["message" => $lastMessage->message, "username" => $lastMessage->member->user->username] : false;

                // Broadcast the DeleteMessage event
                broadcast(new DeleteMessage($this->member()->user->username, $isLatestMessage, $this->uuid));
            }
        }
    }
}
