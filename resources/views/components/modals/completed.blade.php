@props(['debtor'])

<div class="relative" x-data="" x-on:click="$dispatch('open-modal', 'completed-payment{{$debtor->id}}')">
    <x-svg.completed />
    <x-modals.info name="completed-payment{{$debtor->id}}" focusable>
        <form method="post" action="{{ route('payment.complete', $debtor) }}">
            @csrf
            @method('post')

            <div class="p-2 dark:bg-gray-700 rounded-lg rounded-tr-none border-2 border-green-200">
                <h2 class="text-md font-medium text-gray-900 dark:text-gray-100">Полное погашение долга</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                     Вы уверены в осуществлении этой операции?
                </p>

                <div class="flex justify-between items-center gap-2">
                    <x-secondary-button x-on:click.prevent="show = false" class="text-xs px-3 py-2 mt-2 border-none w-1/2 justify-center">
                        Отмена
                    </x-secondary-button>
                    <x-primary-button type="submit" class="text-xs px-3 py-2 mt-2 border-none w-1/2 justify-center">
                        Подтвердить
                    </x-primary-button>
                </div>
            </div>
        </form>
    </x-modals.info>
</div>
