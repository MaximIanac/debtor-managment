@props([
    "debtor"
])

@php
    $payments = $debtor->payments()->orderBy('created_at', 'desc')->get();
@endphp

{{--<form method="get" action="{{ route('payment.history', $debtor) }}">--}}
{{--    @csrf--}}
{{--    @method('get')--}}

{{--    <button type="submit">--}}
{{--        <x-svg.history />--}}
{{--    </button>--}}
{{--</form>--}}

<div class="relative" x-data="" x-on:click="$dispatch('open-modal', 'history-payment{{$debtor->id}}')" >
    <x-svg.history />
    <x-modals.info name="history-payment{{$debtor->id}}" focusable>
        <div class="p-2 dark:bg-gray-700 rounded-lg rounded-tr-none border-2 border-gray-500">
            <p class="my-1 pb-1 text-sm text-gray-600 dark:text-gray-400 border-b border-gray-600 dark:border-gray-400">
                История платежей должника
            </p>
            <div class="flex flex-col gap-2 max-h-[30vh] overflow-y-auto pr-2">
                @foreach($payments as $payment)
                    <div class="flex justify-between items-center">
                        <div class="text-gray-300 text-xs">
                            <p class="text-gray-400" >{{\Illuminate\Support\Carbon::parse($payment->created_at)->format('d.m.y H:i')}}</p>
                            <p>{{$payment->user->fullname}}</p>
                        </div>
                        @if($payment->type === 'increase')
                            <p class="text-green-500">+{{$payment->amount}}</p>
                        @else
                            <p class="text-red-500">-{{$payment->amount}}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </x-modals.info>
</div>
