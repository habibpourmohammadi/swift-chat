<div id="drawer-backdrop"
    class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-64 dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-backdrop-label">
    <div class="pb-4 overflow-y-auto">
        <div class="flex flex-row w-full justify-start items-center gap-3 border-b pb-3 mb-3">
            <div>
                <img src="{{ auth()->user()->avatar }}" class="w-10 rounded-md shadow-sm" alt="">
            </div>
            <div class="flex flex-col gap-2">
                <span class="text-sm text-gray-700">
                    {{ auth()->user()->full_name }}
                </span>
            </div>
        </div>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    <span class="ms-3">خروج از حساب کاربری</span>
                </a>
            </li>
        </ul>
    </div>
</div>
