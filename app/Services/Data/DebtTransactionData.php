<?php

namespace App\Services\Data;

use App\Models\Debtor;
use App\Models\User;
use Spatie\LaravelData\Data;

class DebtTransactionData extends Data
{
    public function __construct(
        public Debtor $debtor,
        public float $amount,
        public User $user,
    ) {}
}
