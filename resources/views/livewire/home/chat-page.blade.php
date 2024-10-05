<div class="flex flex-col md:flex-row w-full h-screen">
    <div class="w-full md:w-2/5 lg:w-1/4 h-screen pt-3 border-l px-2 md:flex md:flex-col hidden">
        @include('partials.home.search')

        @include('partials.home.drawer')
        <div class="flex-1 overflow-y-auto scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
            @forelse ($this->chats as $chat)
                <livewire:home.member :key="$chat->chat->chat_uuid" :member="$chat" />
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
                <div>
                    <img src="{{ $this->member->user->avatar }}" class="w-10 rounded-md shadow-sm"
                        alt="{{ $this->member->user->full_name }}">
                </div>
                <div class="flex flex-col gap-2">
                    <span class="text-sm text-gray-700">
                        {{ $this->member->user->full_name }}
                    </span>
                </div>
            </div>
            <a href="{{ route('home.page') }}" wire:navigate
                class="pt-2 pl-3 text-gray-600 hover:text-red-700 hover:transition-all cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                </svg>
            </a>
        </div>
        <div class="pt-6 px-3 flex flex-col gap-8 overflow-y-auto scroll-smooth pb-5 h-screen"
            style="scrollbar-width: none; -ms-overflow-style: none;" id="chat-list-wrapper">
            @forelse ($this->messages as $message)
                <x-home.chat.message :message="$message" />
            @empty
                <div class="flex justify-center items-center h-screen text-red-500 font-bold text-sm">
                    پیامی ثبت نشده !
                </div>
            @endforelse
        </div>

        <div class="w-full flex items-center gap-3 px-3 pb-2 border-t pt-2 bottom-0">
            <input type="text" id="message"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                autofocus placeholder="پیام خود را بنویسید ..." />
            <button type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">ارسال</button>
        </div>
    </div>
</div>
@script
    <script>
        const chatListWrapper = document.getElementById("chat-list-wrapper");

        updateScrollPosition();

        function updateScrollPosition() {
            chatListWrapper.scrollTop = chatListWrapper.scrollHeight;
        }
    </script>
@endscript
