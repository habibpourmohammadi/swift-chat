<div class="flex flex-col md:flex-row w-full h-screen">
    <div class="w-full md:w-2/5 lg:w-1/4 h-screen pt-3 border-l px-2 md:flex md:flex-col hidden">
        @include('partials.home.search')

        @include('partials.home.drawer')
        <div class="flex-1 overflow-y-auto scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
            @forelse ($this->chats as $chat)
                <livewire:home.member :key="$chat->chat->chat_uuid" :member="$chat"/>
            @empty
                <div class="text-red-500 text-sm text-center h-full flex justify-center items-center font-bold">
                    لیست گفتگو ها خالی است !
                </div>
            @endforelse
        </div>
    </div>

    <div class="w-full md:w-3/5 lg:w-3/4 h-screen flex flex-col">

        <div class="flex flex-row pt-3 w-full bg-gray-50 shadow-sm border-b">
            <div class="flex flex-row w-full justify-start items-center gap-3 pr-3 pb-3.5">
                <div class="relative">
                    <img id="chat-page-header-avatar-{{ $this->member->user->username }}" src="{{ $this->member->user->avatar }}" class="w-10 rounded-md shadow-sm"
                         alt="{{ $this->member->user->full_name }}">
                    <span id="avatar-member-status-{{ $this->member->user->username }}" wire:ignore
                          class="hidden absolute bottom-0 right-8 transform translate-y-1/4 w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                </div>
                <div class="flex flex-col gap-1">
                    <span id="chat-page-header-full-name-{{ $this->member->user->username }}" class="text-sm text-gray-700">
                        {{ $this->member->user->full_name }}
                    </span>
                    <span id="chat-member-is-typing" class="text-sm text-green-400 hidden">
                        <small>
                            در حال نوشتن ...
                        </small>
                    </span>
                </div>
            </div>
            <a href="{{ route('home.page') }}" wire:navigate
               class="pt-2 pl-3 text-gray-600 hover:text-red-700 hover:transition-all cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z"/>
                </svg>
            </a>
        </div>
        <div class="pt-6 px-3 flex flex-col gap-8 overflow-y-auto scroll-smooth pb-5 h-screen"
             style="scrollbar-width: none; -ms-overflow-style: none;" id="chat-list-wrapper">
            @forelse ($this->messages as $chunkMessages)
                <div class="w-full text-center py-2">
                    <span
                        class="bg-gray-100 text-gray-700 px-3 rounded-md border border-green-400 shadow-sm shadow-green-100 text-sm">
                        {{ jalaliDate($chunkMessages->last()->created_at,'%d %B - %Y') }}
                    </span>
                </div>
                @foreach($chunkMessages->all() as $message)
                    <div wire:key="{{ $message->id }}" id="{{ $uuid . '-' . $message->id }}">
                        <x-home.chat.message
                            :message="$message"
                            :editingMessage="$editingMessage"
                        />
                    </div>
                @endforeach
            @empty
                <div class="flex justify-center items-center h-screen text-red-500 font-bold text-sm">
                    پیامی ثبت نشده !
                </div>
            @endforelse
        </div>

        <form id="message-form" class="w-full flex items-center gap-3 px-3 pb-2 border-t pt-2 bottom-0">
            <input type="text" id="message"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   autofocus placeholder="پیام خود را بنویسید ..."/>
            <button type="submit" id="send-button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                ارسال
            </button>
        </form>
    </div>
</div>
@script
<script>
    const chatUuid = $wire.uuid;
    const chatListWrapper = document.getElementById("chat-list-wrapper");
    const messageInput = document.getElementById("message");
    const messageForm = document.getElementById("message-form");

    Echo.join(`chat.${chatUuid}`)
        .listenForWhisper("newChat", createNewMessage)
        .listenForWhisper("currentMemberTyping", currentMemberTyping);

    messageForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let message = messageInput.value;

        if (message.length > 0) {
            $wire.createMessage(message).then(result => {
                messageInput.value = "";

                Echo.join(`chat.${chatUuid}`)
                    .whisper("newChat", {
                        newMessage: result
                    });

                Echo.join("chat")
                    .whisper("changeLastMessage", {
                        message: truncateString(result.message, 20),
                        chat_uuid: chatUuid,
                    });

                updateLastMessage(truncateString(result.message, 20));
            });

            updateScrollPosition(1000);
        }
    });

    messageForm.addEventListener("keyup", (e) => {
        Echo.join(`chat.${chatUuid}`)
            .whisper("currentMemberTyping");

        Echo.join("chat")
            .whisper("memberTyping", {
                chatUuid: $wire.uuid
            });
    });

    function currentMemberTyping(e) {
        let isTypingEl = document.getElementById("chat-member-is-typing");

        setTimeout(() => {
            isTypingEl.classList.add("hidden");
        }, 2000);

        isTypingEl.classList.remove("hidden");
    }

    function createNewMessage(e) {
        let message = e.newMessage;

        chatListWrapper.innerHTML += renderNewMessage(message.id, message.full_name, message.avatar, message.message,
            message.created_at);

        updateScrollPosition();
    }

    function renderNewMessage(id, full_name, avatar, message, created_at) {
        return `
            <div dir="ltr" wire:key="${id}">
                <div class="flex items-start gap-2.5">
                    <img class="w-8 h-8 rounded-full" src="${avatar}" alt="${full_name}">
                    <div class="flex flex-col gap-1 w-fit">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-900">
                                ${full_name}
                    </span>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                ${created_at}
                    </span>
                </div>
                    <div
                        class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                        <p class="text-sm font-normal text-gray-900 dark:text-white">
                                        ${message}
                        </p>
                    </div>
            </div>
              <button id="dropdownMenuIconButton-${id}" data-dropdown-toggle="dropdownDots-${id}"
                            data-dropdown-placement="bottom-start"
                            class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                            type="button">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 4 15">
                            <path
                                d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        </svg>
                    </button>
                    <div id="dropdownDots-${id}"
                         class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownMenuIconButton-${id}">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    حذف
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
        </div>
        `;
    }

    function updateScrollPosition(delay = 0) {
        setTimeout(() => {
            chatListWrapper.scrollTop = chatListWrapper.scrollHeight;

            initFlowbite();
        }, delay);
    }

    function updateLastMessage(message) {
        let messageWrapper = document.getElementById(`last-message-wrapper-${chatUuid}`);

        messageWrapper.innerHTML = renderLastMessage(message);
    }

    function renderLastMessage(message) {
        return `
            <span id="is-owner-of-last-message-${chatUuid}" class="text-blue-500">
              شما :
            </span>
            <span id="last-message-chat-${chatUuid}">
              ${message}
            </span>
        `;
    }

    function truncateString(str, num) {
        if (str.length <= num) {
            return str;
        }
        return str.slice(0, num) + "...";
    }


    updateScrollPosition();
</script>
@endscript
