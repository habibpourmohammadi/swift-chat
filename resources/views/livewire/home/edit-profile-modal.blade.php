<div id="edit-user-profile-modal" tabindex="-1" aria-hidden="true" wire:ignore.self
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    ویرایش حساب
                </h3>
                <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="edit-user-profile-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">بستن فرم</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4 grid grid-cols-2 gap-2" wire:submit="updateProfile">
                    <div class="flex justify-center items-center flex-col gap-2 col-span-2 mb-3">
                        <div class="relative">
                            <a href="{{ $avatar ? $avatar->temporaryUrl() : auth()->user()->avatar }}" target="_blank">
                                <img
                                    class="w-20 h-20 rounded-full border-2 p-0.5 transition-all hover:cursor-pointer hover:border-gray-300"
                                    src="{{ $avatar ? $avatar->temporaryUrl() : auth()->user()->avatar }}"
                                    alt="{{ auth()->user()->full_name }}">
                            </a>
                            <label for="user-avatar"
                                   class="absolute bottom-0 border rounded-lg bg-gray-100 text-gray-400 transition-all hover:text-gray-700 hover:cursor-pointer">
                                <svg wire:loading.remove wire:target="avatar" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                     class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                </svg>
                                <svg wire:loading wire:target="avatar" aria-hidden="true"
                                     class="w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor"/>
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill"/>
                                </svg>
                            </label>
                            <input type="file" id="user-avatar" wire:model="avatar" class="hidden"
                                   accept="image/png, image/jpeg">
                        </div>
                        @error('avatar')
                        <span class="text-xs text-red-600 font-bold">
                                <small>
                                    {{ $message }}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-1">
                        <input type="text" id="first_name" wire:model="first_name"
                               class="bg-gray-50 text-xs border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="نام خود را وار کنید ..."/>
                        @error('first_name')
                        <span class="text-xs text-red-600 font-bold">
                                <small>
                                    {{ $message }}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-1">
                        <input type="text" id="last_name" wire:model="last_name"
                               class="bg-gray-50 text-xs border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="نام خانوادگی خود را وارد کنید ..."/>
                        @error('last_name')
                        <span class="text-xs text-red-600 font-bold">
                                <small>
                                    {{ $message }}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-1">
                        <input dir="ltr" type="text" id="username" wire:model="username"
                               class="bg-gray-50 text-xs border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="نام کاربری خود را وارد کنید ..."/>
                        @error('username')
                        <span class="text-xs text-red-600 font-bold">
                                <small>
                                    {{ $message }}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-1">
                        <input dir="ltr" type="number" id="mobile" readonly
                               value="{{ auth()->user()->mobile }}"
                               class="bg-gray-50 text-xs border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               placeholder="تلفن همراه خود را وارد کنید ..."/>
                    </div>
                    <div class="col-span-2">
                        <input type="text" wire:model="birthday"
                               class="bg-gray-50 text-center text-xs border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               x-mask="9999/99/99" placeholder="لطفا تاریخ تولد خود را مانند فرمت روبرو وارد کنید : 1372/08/05">
                        @error('birthday')
                            <span class="text-xs text-red-600 font-bold">
                                    <small>
                                        {{ $message }}
                                    </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <textarea
                            wire:model="bio"
                            class="bg-gray-50 text-xs border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            cols="30" rows="5" placeholder="لطفا بایو خود را وارد کنید ..."></textarea>
                        @error('bio')
                            <span class="text-xs text-red-600 font-bold">
                                    <small>
                                        {{ $message }}
                                    </small>
                            </span>
                        @enderror
                    </div>
                    <button type="submit"
                            class="col-span-2 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ویرایش حساب
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
