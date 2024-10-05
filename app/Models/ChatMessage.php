<?php

namespace App\Models;

use App\Models\Chat;
use App\Models\ChatMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChatMember::class);
    }
}
