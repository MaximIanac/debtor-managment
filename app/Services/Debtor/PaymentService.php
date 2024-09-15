<?php

namespace App\Services\Debtor;

use App\Charts\AllPayments;
use App\Charts\BigDebts;
use App\Enums\PaymentType;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PaymentService
{
    private function getPayments($startDate, $endDate)
    {
        return Payment::whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function getBigDebtsChart(Collection $debtors): BigDebts
    {
        $chart = new BigDebts();

        $chart
            ->minimalist(true)
//            ->displayLegend(true)
            ->labels($debtors->map(fn ($debtor) => $debtor->name))
            ->dataset('My dataset', 'pie', $debtors->map(fn ($debtor) => $debtor->total_debt))
            ->color('transparent')
            ->backgroundColor([
                '#FF6384', // Красный
                '#36A2EB', // Синий
                '#FFCE56', // Желтый
                '#4BC0C0', // Бирюзовый
                '#9966FF', // Фиолетовый
                '#FF9F40', // Оранжевый
                '#FF6384', // Красный
                '#36A2EB', // Синий
                '#FFCE56', // Желтый
                '#4BC0C0', // Бирюзовый
            ])
            ->fill(false)
            ->lineTension(0.1);

        return $chart;
    }

    public function getAllPaymentsChart(Collection $payments): AllPayments
    {
        $chart = new AllPayments();

        $increasePayments = $payments->where('type', '=', PaymentType::Increase->value)->collect();
        $decreasePayments = $payments->where('type', '=', PaymentType::Decrease->value)->collect();

        function getDailyTotals($payments) {
            return $payments->groupBy(function($payment) {
                return $payment->created_at->toDateString();
            })->map(function($group) {
                return $group->sum('amount');
            });
        }

        $increaseTotals = getDailyTotals($increasePayments);
        $decreaseTotals = getDailyTotals($decreasePayments);

        $labels = $increaseTotals->keys()->merge($decreaseTotals->keys())->unique()->sort()->values();

        $increaseAmounts = $labels->map(function ($date) use ($increaseTotals) {
            return $increaseTotals->get($date, 0);
        });

        $decreaseAmounts = $labels->map(function ($date) use ($decreaseTotals) {
            return $decreaseTotals->get($date, 0);
        });

        $labels = $labels->map(function ($date) {
                return Carbon::parse($date)->format('d.m.y');
            });

        $chart->minimalist(false)
            ->displayLegend(false)
            ->labels($labels)
            ->dataset('Увеличение долга', 'line', $increaseAmounts)
            ->color('rgb(34 197 94)')
            ->fill(true)
            ->lineTension(0.1);

        $chart->dataset('Погашение долга', 'line', $decreaseAmounts)
            ->color('rgb(239 68 68)')
            ->fill(true)
            ->lineTension(0.1);


        return $chart;
    }

    public function getRecordDebtsWriter(Collection $users): BigDebts
    {
        $chart = new BigDebts();

        $chart
            ->minimalist(false)
            ->displayLegend(false)
            ->labels($users->map(fn ($user) => $user->fullname))
            ->dataset('Число записей', 'bar', $users->map(fn ($user) => $user->payments->where('type', PaymentType::Increase->value)->count()))
            ->backgroundColor('#36A2EB');

        $chart
            ->dataset('Возвращено (кол-во)', 'bar', $users->map(fn ($user) => $user->payments->where('type', PaymentType::Decrease->value)->count()))
            ->backgroundColor('red');

        return $chart;
    }

    public function getRecordDebtsRecipient(Collection $users): BigDebts
    {
        $chart = new BigDebts();

        $chart
            ->minimalist(false)
            ->displayLegend(false)
            ->labels($users->map(fn ($user) => $user->fullname))
            ->dataset('Возвращено (сумма)', 'bar', $users->map(fn ($user) => $user->payments->where('type', PaymentType::Decrease->value)->sum('amount')))
            ->backgroundColor('blue');

        return $chart;
    }

    public function getDailyPayments()
    {
        return $this->getPayments(Carbon::now()->startOfDay(), Carbon::now()->endOfDay());
    }

    public function getWeeklyPayments()
    {
        return $this->getPayments(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
    }

    public function getMonthlyPayments()
    {
        return $this->getPayments(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
    }

    public function getDailyPaymentsPlus()
    {
        return $this->getDailyPayments()->where('type', '=', 'increase')->sum('amount');
    }

    public function getDailyPaymentsMinus()
    {
        return $this->getDailyPayments()->where('type', '=', 'decrease')->sum('amount');
    }

    public function getWeeklyPaymentsPlus()
    {
        return $this->getWeeklyPayments()->where('type', '=', 'increase')->sum('amount');
    }

    public function getWeeklyPaymentsMinus()
    {
        return $this->getWeeklyPayments()->where('type', '=', 'decrease')->sum('amount');
    }

    public function getMonthlyPaymentsPlus()
    {
        return $this->getMonthlyPayments()->where('type', '=', 'increase')->sum('amount');
    }

    public function getMonthlyPaymentsMinus()
    {
        return $this->getMonthlyPayments()->where('type', '=', 'decrease')->sum('amount');
    }
}
