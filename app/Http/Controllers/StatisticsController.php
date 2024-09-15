<?php

namespace App\Http\Controllers;

use App\Charts\BigDebts;
use App\Http\Controllers\Controller;
use App\Models\Debtor;
use App\Models\Payment;
use App\Models\User;
use App\Services\Debtor\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function index()
    {
        $debtors = Debtor::where('is_paid', '=', 'true')->orderBy('total_debt', 'desc')->take(10)->get();
        $users = User::all();

        $bigDebtsChart = $this->paymentService->getBigDebtsChart($debtors);

        $allPaymentsChart = $this->paymentService->getAllPaymentsChart($this->paymentService->getMonthlyPayments());

        $recordDebts = $this->paymentService->getRecordDebtsWriter($users);
        $recordRecipient = $this->paymentService->getRecordDebtsRecipient($users);

        $daily = [
            'increase' => $this->paymentService->getDailyPaymentsPlus(),
            'decrease' => $this->paymentService->getDailyPaymentsMinus(),
        ];
        $weekly = [
            'increase' => $this->paymentService->getWeeklyPaymentsPlus(),
            'decrease' => $this->paymentService->getWeeklyPaymentsMinus(),
        ];
        $monthly = [
            'increase' => $this->paymentService->getMonthlyPaymentsPlus(),
            'decrease' => $this->paymentService->getMonthlyPaymentsMinus(),
        ];

        return view('statistics.index', [
            'bigDebtsChart' => $bigDebtsChart,
            'allPaymentsChart' => $allPaymentsChart,
            'recordDebts' => $recordDebts,
            'recordRecipient' => $recordRecipient,
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
        ]);
    }
}
