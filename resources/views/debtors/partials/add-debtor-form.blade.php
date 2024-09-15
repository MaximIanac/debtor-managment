<section class="space-y-12">
    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-new-debtor')">
        Добавить нового должника
    </x-primary-button>

    <x-modal name="add-new-debtor" focusable>
        <form method="post" action="{{ route('debtors.store') }}" class="p-6">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Добавление должника в реестр
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Добавление в список должников нового человека. Внимательно введите сумму долга, дальнейшее редактирование возможно только при помощи ввода платежей
            </p>

            <div class="flex items-center gap-4 mt-6">
                <x-input-label for="name" value="{{ __('Имя должника') }}" class="sr-only" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Введите имя') }}"
                />

                <x-input-label for="sum" value="{{ __('Сумма долга') }}" class="sr-only" />
                <x-text-input
                    id="sum"
                    name="amount"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Введите сумму') }}"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Отмена
                </x-secondary-button>

                <x-primary-button type="submit" class="ms-3">
                    Добавить
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>

