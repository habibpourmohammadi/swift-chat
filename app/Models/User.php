<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ChatMember;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'mobile',
        'mobile_verified_at',
        'password',
        'birthday',
        'bio',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Retrieve chat members excluding the authenticated user.
     */
    public function chats()
    {
        // Query chats where the authenticated user is a member
        $chats = Chat::query()->whereHas("members", function ($query) {
            return $query->where("user_id", Auth::user()->id);
        })
            // Load related members for each chat
            ->with("members")
            ->get();

        // Map through chats to get the first member who isn't the authenticated user
        $members = $chats->map(function ($chat) {
            return $chat->members->reject(function ($member) {
                return $member->user_id == Auth::user()->id;
            })->first();
        });

        return $members;
    }

    public function members(): HasMany
    {
        return $this->hasMany(ChatMember::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function avatar(): Attribute
    {
        return new Attribute(
            get: fn($value) => isset($value) ? Storage::url($value) : Vite::asset("resources/images/avatar/default-avatar.jpg")
        );
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function canSeeChat(string $chat_uuid)
    {
        // Query the chat by its UUID and ensure the current user is a member of that chat
        $chat = Chat::where("chat_uuid", $chat_uuid)->whereHas("members", function ($query) {
            // Check if the current user is part of the chat's members
            return $query->where("user_id", $this->id);
        })
            ->with("members")
            ->first();

        // Return true if the chat exists and the user is a member, otherwise return false
        return $chat == null ? false : true;
    }
}
