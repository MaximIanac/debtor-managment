@props([
    "debtor"
])

<div class="relative" x-data="" x-on:click="$dispatch('open-modal', 'minus-payment{{$debtor->id}}')" >
    <x-svg.minus />
    <x-modals.info name="minus-payment{{$debtor->id}}" focusable>
        <form method="post" action="{{ route('payment.decrease', $debtor) }}">
            @csrf
            @method('post')

            <div class="p-2 dark:bg-gray-700 rounded-lg rounded-tr-none border-2 border-red-200">
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Внесение суммы для частичного погашения долга
                </p>

                <x-text-input
                    id="amount"
                    name="amount"
                    type="number"
                    min="0"
                    step="0.1"
                    class="block w-48 mt-3 border-none text-xs px-3 py-2 appearance-none"
                    placeholder="{{ __('Сумма..') }}"
                    aria-describedby="amount-error"
                    required
                />

                <x-primary-button class="mt-3 mb-2 text-[10x] px-[12px] py-1 ">
                    Внести
                </x-primary-button>
            </div>
        </form>
    </x-modals.info>
</div>


