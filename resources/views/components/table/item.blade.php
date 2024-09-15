<div class="p-2">
    {{ $debtor->name }}
</div>
<div class="p-2">
    {{ number_format($debtor->total_debt, 2, ',', ' ') }} MDL
</div>
<div class="p-2">
    {{ $debtor->user->fullname ?? 'Пользователь не найден' }}
</div>
<div class="p-2 flex justify-between relative">
    {{ \Carbon\Carbon::parse($debtor->created_at)->format('d.m.y H:i') }}

    <div class="items-center justify-start gap-2 hidden lg:flex">
        <x-modals.minus :debtor="$debtor" />
        <x-modals.plus :debtor="$debtor" />
        @if(auth()->user()->hasRole('admin'))
            <x-modals.history :debtor="$debtor" />
        @endif
        <x-modals.completed :debtor="$debtor" />
    </div>

    @php
        $errorsKey = "amount-$debtor->id";
    @endphp

    @if(session("success-$debtor->id"))
        <x-alert type="success">{{ session("success-$debtor->id") }}</x-alert>
    @endif

    @if($errors->has($errorsKey))
        <x-alert type="error"> {{ $errors->first($errorsKey) }} </x-alert>
    @endif

    <div x-data="{ open: false }" class="block lg:hidden">
        <div class="relative">
            <div @click="open = !open">
                <x-svg.more />
            </div>

            <div
                x-show="open"
                @click.away="open = false"
                class="absolute z-40 bg-gray-200 dark:bg-gray-700 rounded shadow-2xl p-2 mt-2 -left-20 -top-7"
            >
                <div class="flex flex-col items-center justify-start gap-3">
                    <div class="flex items-center justify-start gap-3">
                        <x-modals.minus :debtor="$debtor" />
                        <x-modals.plus :debtor="$debtor" />
                    </div>
                    <div class="flex items-center justify-start gap-3">
                        @if(auth()->user()->hasRole('admin'))
                            <x-modals.history :debtor="$debtor" />
                        @endif
                        <x-modals.completed :debtor="$debtor" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
