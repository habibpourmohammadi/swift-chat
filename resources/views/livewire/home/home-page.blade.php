<div class="flex flex-col md:flex-row w-full h-screen">
    <div class="w-full md:w-2/5 lg:w-1/4 h-screen pt-3 border-l px-2 flex flex-col">
        @include('partials.home.search')

        @include('partials.home.drawer')
        <div class="flex-1 overflow-y-auto scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
            @for ($i = 0; $i <= 9; $i++)
                <div
                    class="flex flex-row w-full justify-between hover:bg-gray-100 hover:cursor-pointer hover:transition-all rounded-lg p-1.5 my-2.5">
                    <div class="flex gap-2">
                        <div>
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
                                class="w-12 rounded-lg" alt="">
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-sm text-gray-800">
                                حبیب الله پورمحمدی
                            </span>
                            <span class="text-xs text-gray-400">
                                <span class="text-blue-500">
                                    شما :
                                </span>
                                <span>
                                    سلام حبیب حالت چطور ...
                                </span>
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">
                            <small>
                                <small>
                                    5 دقیقه
                                </small>
                            </small>
                        </span>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="w-full md:w-3/5 lg:w-3/4 h-screen hidden md:flex justify-center items-center">
        <img src="{{ Vite::asset('resources/images/background/bird.png') }}" class="w-1/2" alt="">
    </div>
</div>
