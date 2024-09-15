<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Debtor;
use App\Models\Payment;
use App\Services\Data\DebtTransactionData;
use App\Services\Debtor\DebtorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected DebtorService $ds;

    public function __construct(DebtorService $ds) {
        $this->ds = $ds;
    }

    public function decrease(Request $request, Debtor $debtor): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $amount = $validated['amount'];

        if ($amount > $debtor->total_debt) {
            return redirect()->back()->withErrors(["amount-$debtor->id" => "Введенное число ($amount) превышает размер долга."]);
        }

        $data = DebtTransactionData::from([
            'debtor' => $debtor,
            'amount' => $amount,
            'user' => Auth::user(),
        ]);

        $this->ds->decreaseDebt($data);

        return redirect()->route('debtors')->with("success-$debtor->id", "Долг ({$debtor->name}) уменьшен");
    }

    public function increase(Request $request, Debtor $debtor): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $amount = $validated['amount'];

        $data = DebtTransactionData::from([
            'debtor' => $debtor,
            'amount' => $amount,
            'user' => Auth::user(),
        ]);

        $this->ds->increaseDebt($data);

        return redirect()->route('debtors')->with("success-$debtor->id", "Долг ({$debtor->name}) увеличен");
    }

    public function complete(Request $request, Debtor $debtor): RedirectResponse
    {
        $data = DebtTransactionData::from([
            'debtor' => $debtor,
            'amount' => $debtor->total_debt,
            'user' => Auth::user(),
        ]);

        $this->ds->repayDebt($data);

        //TODO: Добавить фактор ошибки

        return redirect()->route('debtors')->with("success-$debtor->id", "{$debtor->name} выписан");
    }
}
