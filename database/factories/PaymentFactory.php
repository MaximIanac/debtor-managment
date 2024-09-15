<?php

namespace Database\Factories;

use App\Models\Debtor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $debtorId = Debtor::pluck('id')->random(); // Выбор случайного ID дебитора
        $userId = User::pluck('id')->random(); // Выбор случайного ID пользователя

        $startDate = Carbon::now()->subMonth(); // Дата начала периода (1 месяц назад)
        $endDate = Carbon::now(); // Дата конца периода (текущий момент)

        $minAmount = 25; // Минимальная сумма
        $maxAmount = 1500; // Максимальная сумма
        $amount = $this->faker->numberBetween($minAmount * 2, $maxAmount * 2) / 2; // Шаг 0.5

        return [
            'debtor_id' => $debtorId,
            'user_id' => $userId,
            'amount' => $amount,
            'type' => $this->faker->randomElement(['increase', 'decrease']), // Случайный тип
            'created_at' => $this->faker->dateTimeBetween($startDate, $endDate),
        ];
    }

    /**
     * Генерация набора платежей для одного должника с суммой равной нулю или положительной.
     *
     * @param int $debtorId
     * @param int $numberOfPayments
     * @return void
     */
    public static function generatePaymentsForDebtor($debtorId, $numberOfPayments)
    {
        $payments = collect();
        $totalAmount = 0;

        for ($i = 0; $i < $numberOfPayments; $i++) {
            $amount = fake()->randomFloat(1, 5, 500); // Генерация суммы
            $type = fake()->randomElement(['increase', 'decrease']); // Генерация типа

            if ($type === 'increase') {
                $totalAmount += $amount;
            } else {
                $totalAmount -= $amount;
            }

            // Добавляем платеж к коллекции
            $payments->push([
                'debtor_id' => $debtorId,
                'user_id' => User::pluck('id')->random(),
                'amount' => $amount,
                'type' => $type,
                'created_at' => fake()->dateTimeBetween(Carbon::now()->subMonth(), Carbon::now()),
            ]);
        }

        // Корректируем сумму, чтобы обеспечить условие
        if ($totalAmount < 0) {
            $payments->each(function (&$payment) use (&$totalAmount) {
                if ($payment['type'] === 'decrease') {
                    $adjustment = min(abs($totalAmount), $payment['amount']);
                    $payment['amount'] -= $adjustment;
                    $totalAmount += $adjustment;
                }
            });
        }

        DB::table('payments')->insert($payments->toArray());
    }
}
