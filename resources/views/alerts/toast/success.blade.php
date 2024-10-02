<div x-data="{ toasts: [] }"
    x-on:toast-success.window="toasts.push({message: $event.detail.message, title: $event.detail.title, id: Date.now()})">
    <!-- Container for Toasts -->
    <div class="fixed bottom-5 right-5 flex flex-col-reverse space-y-2 space-y-reverse" style="z-index: 9999;">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-cloak x-transition
                class="flex items-center justify-between max-w-xs p-4 mb-4 bg-white rounded-lg shadow-lg space-x-4 w-full">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 flex justify-center items-center text-green-500 bg-green-100 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                          </svg>
                    </div>
                    <div class="mr-3 ml-3 text-sm font-normal">
                        <span class="block text-xs mb-0.5" x-text="toast.title"></span>
                        <span x-text="toast.message"></span>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
