<div {{ $message->member->user_id == auth()->user()->id ? 'dir=rtl' : 'dir=ltr' }}>
    <div class="flex items-start gap-2.5">
        <img class="w-8 h-8 rounded-full" src="{{ $message->member->user->avatar }}" alt="Jese image">
        <div class="flex flex-col gap-1 w-fit">
            <div class="flex items-center gap-2">
                <span @class([
                    'text-sm font-semibold',
                    'text-blue-600' => $message->member->user_id == auth()->user()->id,
                    'text-gray-900' => $message->member->user_id != auth()->user()->id,
                ])>
                    {{ $message->member->user_id == auth()->user()->id ? 'شما' : $message->member->user->full_name }}
                </span>
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    {{ jalaliDate($message->created_at, 'H:i') }}
                </span>
            </div>
            <div
                class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                <p class="text-sm font-normal text-gray-900 dark:text-white">
                    {{ $message->message }}
                </p>
            </div>
        </div>
        <button id="dropdownMenuIconButton-{{ $message->id }}" data-dropdown-toggle="dropdownDots-{{ $message->id }}"
            data-dropdown-placement="bottom-start"
            class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
            type="button">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 4 15">
                <path
                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
            </svg>
        </button>
        <div id="dropdownDots-{{ $message->id }}"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownMenuIconButton-{{ $message->id }}">
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