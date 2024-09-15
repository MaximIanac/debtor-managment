<?php

namespace App\Services\Debtor;

use App\Enums\PaymentType;
use App\Models\Payment;
use App\Services\Data\DebtTransactionData;
use Illuminate\Support\Facades\DB;

class DebtorService
{
    public function increaseDebt(DebtTransactionData $data)
    {
        return DB::transaction(function () use ($data) {
            $data->debtor->increment('total_debt', $data->amount);
            return $this->logPayment($data, PaymentType::Increase);
        });
    }

    public function decreaseDebt(DebtTransactionData $data)
    {
        return DB::transaction(function () use ($data) {
            $data->debtor->decrement('total_debt', $data->amount);
            return $this->logPayment($data, PaymentType::Decrease);
        });
    }

    public function repayDebt(DebtTransactionData $data): bool
    {
        $payment = $this->decreaseDebt($data);

        if (!($payment instanceof Payment)) {
            return false;
        }

        if ($data->debtor->total_debt == 0) {
            $data->debtor->is_paid = true;
            $data->debtor->save();
        }

        return true;
    }

    private function logPayment(DebtTransactionData $data, PaymentType $type)
    {
        return Payment::create([
            'debtor_id' => $data->debtor->id,
            'user_id' => $data->user->id,
            'amount' => $data->amount,
            'type' => $type->value,
        ]);
    }
}
