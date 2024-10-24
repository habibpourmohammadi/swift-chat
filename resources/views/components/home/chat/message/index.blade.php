<div {{ $message->member->user_id == auth()->user()->id ? 'dir=rtl' : 'dir=ltr' }}>
    <div class="flex items-start gap-2.5">
        <img class="w-8 h-8 rounded-full chat-page-avatar-{{ $message->member->user->username }}"
             src="{{ $message->member->user->avatar }}" alt="{{ $message->member->user->full_name }}">
        <div class="flex flex-col gap-1 w-fit">
            <div class="flex items-center gap-2">
                <span @class([
                    'text-sm font-semibold',
                    'text-blue-600' => $message->member->user_id == auth()->user()->id,
                    'text-gray-900 chat-page-full-name-' . $message->member->user->username => $message->member->user_id != auth()->user()->id,
                ])>
                    {{ $message->member->user_id == auth()->user()->id ? 'شما' : $message->member->user->full_name }}
                </span>
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    {{ jalaliDate($message->created_at, 'H:i') }}
                </span>
            </div>
            <div
                class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                @if($editingMessage && $editingMessage === $message->id)
                    <div class="flex items-center justify-center gap-2">
                        <input type="text" wire:model="newMessageContent"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        />
                        <button type="button" wire:click="updateMessage"
                                class="bg-green-500 text-gray-200 rounded-md p-1.5 shadow-md hover:bg-green-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </button>
                    </div>
                @else
                    <p class="text-sm font-normal text-gray-900 dark:text-white">
                        {{ $message->message }}
                    </p>
                @endif
            </div>
            @if($message->updated_at != $message->created_at)
                <span class="text-xs text-blue-500">
                   <small>
                      <strong>
                          ویرایش شده
                      </strong>
                   </small>
                </span>
            @endif
        </div>
        <button id="dropdownMenuIconButton-{{ $message->id }}" data-dropdown-toggle="dropdownDots-{{ $message->id }}"
                data-dropdown-placement="bottom-start"
                class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                type="button">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 4 15">
                <path
                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
            </svg>
        </button>
        <div id="dropdownDots-{{ $message->id }}"
             class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownMenuIconButton-{{ $message->id }}">
                <li>
                    <button wire:click="deleteMessage({{ $message->id }})" type="button"
                            class="w-full text-right block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        حذف
                    </button>
                </li>
                @if($message->member->user_id == auth()->user()->id)
                    <li>
                        <button wire:click="set('editingMessage', {{ $message->id }})" type="button"
                                class="w-full text-right block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            ویرایش
                        </button>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
