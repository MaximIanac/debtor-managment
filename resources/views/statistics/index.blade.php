<x-app-layout>
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp

    <x-slot name="header">
        <h2 class="flex justify-between items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Статистика') }}
            <p>Вы вошли как: {{ $user->fullname }}</p>
        </h2>
    </x-slot>

    <div class="flex flex-col gap-8">
        <div class="flex flex-col items-center gap-4">
            <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100 text-center mb-2">Долговые платежи</h2>
            <div class="w-full">
                <div class="flex justify-center items-center gap-6">
                    <div>
                        <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">за день</p>
                        <span class="text-green-500 pr-2">+{{ $daily['increase'] }}</span>
                        <span class="text-red-500">-{{ $daily['decrease'] }}</span>
                    </div>
                    <div>
                        <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">за неделю</p>
                        <span class="text-green-500 pr-2">+{{ $weekly['increase'] }}</span>
                        <span class="text-red-500">-{{ $weekly['decrease'] }}</span>
                    </div>
                    <div>
                        <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">за месяц</p>
                        <span class="text-green-500 pr-2">+{{ $monthly['increase'] }}</span>
                        <span class="text-red-500">-{{ $monthly['decrease'] }}</span>
                    </div>
                </div>

                <div class="w-full mt-8 h-[300px]">
                    {!! $allPaymentsChart->container() !!}

                    {!! $allPaymentsChart->script() !!}
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 items-center gap-8">
            <div class="flex flex-col items-center justify-start gap-8 h-full">
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
                    Самые большие задолженности
                </h2>
                <div class="h-max-[500px] w-3/5">
                    {!! $bigDebtsChart->container() !!}

                    {!! $bigDebtsChart->script() !!}
                </div>
            </div>

            <div class="flex flex-col items-center justify-start gap-8 h-full">
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
                    Статистика по пользователям
                </h2>
                <div class="flex justify-between items-center h-max-[500px] w-full">
                    <div class="w-1/2">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 text-center">Записанные и возвращенные долги</p>
                        <div>
                            {!! $recordDebts->container() !!}

                            {!! $recordDebts->script() !!}
                        </div>
                    </div>
                    <div class="w-1/2">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 text-center">Возвращенная сумма</p>
                        <div>
                            {!! $recordRecipient->container() !!}

                            {!! $recordRecipient->script() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
