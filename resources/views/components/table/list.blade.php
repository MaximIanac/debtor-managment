@props(['debtor'])

@if (isset($debtor))
    <div class="grid grid-cols-4 gap-2 text-xs md:text-sm lg:text-md py-1 border-b-2 border-gray-300 dark:border-gray-900 last:border-b-0">
        <x-table.item :debtor="$debtor"></x-table.item>
    </div>
@else
    <div class="grid grid-cols-4 gap-2 text-xs md:text-sm lg:text-lg py-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
        <div class="p-2">
            <span class="font-bold text-gray-800 dark:text-gray-100">Должник</span>
        </div>
        <div class="p-2">
            <span class="font-bold text-gray-800 dark:text-gray-100">Сумма</span>
        </div>
        <div class="p-2">
            <span class="font-bold text-gray-800 dark:text-gray-100">Кем вписан</span>
        </div>
        <div class="p-2">
            <span class="font-bold text-gray-800 dark:text-gray-100">Дата</span>
        </div>
    </div>
@endif




