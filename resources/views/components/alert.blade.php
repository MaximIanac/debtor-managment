@props(['type'])

<div
    x-data="{ open: true }"
    x-show="open"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    class="fixed bottom-0 right-0 m-4 p-4 z-40 overflow-hidden transform w-auto transition-all">
    <div
        x-on:click="open = false"
        class="p-4 text-sm rounded-lg cursor-pointer
            {{ $type === 'success' ? 'text-green-800 bg-green-50 dark:bg-green-100 dark:text-green-800' : '' }}
            {{ $type === 'error' ? 'text-red-800 bg-red-50 dark:bg-red-100 dark:text-red-800' : '' }}
            {{ $type === 'warning' ? 'text-yellow-800 bg-yellow-50 dark:bg-yellow-100 dark:text-yellow-800' : '' }}"
        role="alert"
    >
        <span class="font-medium">
            @if ($type === 'success')
                Успех!
            @elseif ($type === 'error')
                Ошибка!
            @elseif ($type === 'warning')
                Предупреждение!
            @endif
        </span>
        {{ $slot }}
    </div>
</div>
