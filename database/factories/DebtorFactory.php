<?php

namespace Database\Factories;

use App\Models\Debtor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Debtor>
 */
class DebtorFactory extends Factory
{
    protected $model = Debtor::class;

    public function definition()
    {
        $startDate = Carbon::now()->subWeek();
        $endDate = Carbon::now();

        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'name' => $this->faker->name(),
            'total_debt' => $this->faker->randomFloat(2, 10, 1000),
            'is_paid' => false,
            'created_at' => $this->faker->dateTimeBetween($startDate, $endDate),
        ];
    }
}
