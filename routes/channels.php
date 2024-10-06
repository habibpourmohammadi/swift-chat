<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel("chat.{chatUuid}", function (User $user, string $chatUuid) {
    if ($user->canSeeChat($chatUuid)) {
        return [
            "full_name" => $user->full_name,
            "username" => $user->username,
            "avatar" => $user->avatar,
        ];
    }
});
