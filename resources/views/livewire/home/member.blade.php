<div wire:click="redirectToChatPage"
     class="flex flex-row w-full justify-between hover:bg-gray-100 hover:cursor-pointer hover:transition-all rounded-lg p-1.5 my-2.5">
    <div class="flex gap-2">
        <div>
            <img src="{{ $member->user->avatar }}" class="w-12 rounded-lg" alt="{{ $member->user->full_name }}">
        </div>
        <div class="flex flex-col gap-2">
            <span class="text-sm text-gray-800">
                {{ $member->user->full_name }}
            </span>
            @if ($this->latestMessage != null)
                <span id="last-message-wrapper-{{ $member->chat->chat_uuid }}" class="text-xs text-gray-400">
                    @if ($this->latestMessage->member->user_id == auth()->user()->id)
                        <span id="is-owner-of-last-message-{{ $member->chat->chat_uuid }}" class="text-blue-500">
                            شما :
                        </span>
                    @endif
                    <span id="last-message-chat-{{ $member->chat->chat_uuid }}">
                        @if ($this->latestMessage->message_type == 'text')
                            {{ Str::limit($this->latestMessage->message, 20, '...') }}
                        @else
                            <span class="text-green-500">
                                یک فایل ارسال شده !
                            </span>
                        @endif
                    </span>
                </span>
            @else
                <span class="text-xs text-red-400 font-bold">
                    <span>
                        پیامی ثبت نشده !
                    </span>
                </span>
            @endif
        </div>
    </div>
    <div>
        <span class="text-sm text-gray-500">
            <small class="flex flex-col items-center justify-between gap-2">
                <small>
                    {{ $this->latestMessage ? $this->latestMessage->created_at->ago() : '' }}
                </small>
                <small id="member-status-{{ $member->user->username }}">
                    <span id="member-status-{{ $member->chat->chat_uuid }}"
                          class="hidden bg-green-100 text-green-800 font-medium me-2 px-2.5 py-0.5 rounded"></span>
                </small>
            </small>
        </span>
    </div>
</div>
