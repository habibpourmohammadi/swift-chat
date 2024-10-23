<div class="flex flex-col md:flex-row w-full h-screen">
    <div class="w-full md:w-2/5 lg:w-1/4 h-screen pt-3 border-l px-2 flex flex-col">
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

    <div class="w-full md:w-3/5 lg:w-3/4 h-screen hidden md:flex justify-center items-center">
        <img src="{{ Vite::asset('resources/images/background/bird.png') }}" class="w-1/2" alt="">
    </div>
</div>
