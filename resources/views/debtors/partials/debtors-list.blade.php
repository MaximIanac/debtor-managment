<x-table.list />
@foreach ($debtors as $debtor)
    @if (!$debtor->is_paid)
        <x-table.list :debtor="$debtor" />
    @endif
@endforeach
