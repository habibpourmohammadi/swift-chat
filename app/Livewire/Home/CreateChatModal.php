<?php

namespace App\Livewire\Home;

use App\Events\CreateNewChat;
use App\Models\Chat;
use App\Models\ChatMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateChatModal extends Component
{
    #[Validate(["required", "exists:users,username"])]
    public $username = "";

    /**
     * Handles the chat creation process.
     */
    public function createChat()
    {
        // Validate the username field against the rules
        $this->validate();

        // Find the user by the given username
        $user = User::where("username", $this->username)->first();

        // Prevent the user from creating a chat with themselves
        if ($user->id === Auth::user()->id) {
            $this->addError("username", "شما نمیتوانید نام کاربری خود را وارد کنید");
            return;
        }

        // Check if a chat already exists between the logged-in user and the requested user
        $chat = Auth::user()->chats()->where("user_id", $user->id)->first();

        // If a chat exists, redirect to the existing chat page
        if ($chat) {
            $this->redirectRoute("home.chat.page", [$chat->chat->chat_uuid], navigate: true);
        }

        // If no chat exists, create a new chat using a database transaction
        DB::transaction(function () use ($user, &$chat) {
            // Create a new chat instance
            $chat = Chat::create([
                "chat_uuid" => Str::uuid(),
            ]);

            // Add the logged-in user as a member of the new chat
            $loggedInUser = ChatMember::create(
                [
                    "chat_id" => $chat->id,
                    "user_id" => Auth::user()->id
                ],
            );

            // Add the requested user as a member of the new chat
            $requestedUser = ChatMember::create(
                [
                    "chat_id" => $chat->id,
                    "user_id" => $user->id
                ],
            );
        });

        // Broadcast the new chat creation event to notify The requested User
        broadcast(new CreateNewChat($this->username))->toOthers();

        // Redirect to the newly created chat page
        $this->redirectRoute("home.chat.page", [$chat->chat_uuid], navigate: true);
    }
}
