@props(['type' => 'text', 'label',  'id', 'placeholder' => null])
<div class="mb-5">
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}
        <span class="text-red-600">
            *
        </span>
    </label>
    <input type="{{ $type }}" id="{{ $id }}" {{ $attributes }}
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="{{ $placeholder }}"  />
    @error($attributes["wire:model"] ?? $attributes["wire:model.live.debounce.250ms"])
        <span class="text-red-500 text-xs pr-0.5 font-bold">
            {{ $message }}
        </span>
    @enderror
</div>
