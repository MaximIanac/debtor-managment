<?php

namespace Database\Seeders;

use App\Models\Debtor;
use App\Models\Payment;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'fullname' => 'Татьяна Янак Феодосьевна',
            'login' => 'ianac',
            'password' => bcrypt('password'),
        ])->create([
            'fullname' => 'Test',
            'login' => 'test',
            'password' => bcrypt('password'),
        ])->create([
            'fullname' => 'Test2',
            'login' => 'test2',
            'password' => bcrypt('password'),
        ])->create([
            'fullname' => 'Test3',
            'login' => 'test3',
            'password' => bcrypt('password'),
        ]);

        $debtors = Debtor::factory()->count(10)->create()->all();

        foreach ($debtors as $debtor) {
            PaymentFactory::generatePaymentsForDebtor($debtor->id, rand(5, 15));
        }

        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);

        $viewDebtors = Permission::create(['name' => 'view debtors']);
        $viewStatistics = Permission::create(['name' => 'view statistics']);
        $manageEmployers = Permission::create(['name' => 'manage employers']);

        $adminRole->givePermissionTo([$viewDebtors, $viewStatistics, $manageEmployers]);
        $managerRole->givePermissionTo($viewDebtors);

        $user = User::find(1);
        $user->assignRole('admin');
    }
}
