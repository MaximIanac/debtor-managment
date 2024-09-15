<?php

use App\Http\Controllers\DebtorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('debtors');
})->middleware('auth');

Route::get('/calc', [DebtorController::class, 'get']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('debtors')->group(function () {
        Route::get('/', [DebtorController::class, 'index'])->name('debtors');
        Route::post('/', [DebtorController::class, 'store'])->name('debtors.store');

        Route::post('{debtor}/decrease', [PaymentController::class, 'decrease'])->name('payment.decrease');
        Route::post('{debtor}/increase', [PaymentController::class, 'increase'])->name('payment.increase');
        Route::post('{debtor}/complete', [PaymentController::class, 'complete'])->name('payment.complete');
    });

    Route::group(['middleware' => ['role:admin'], 'prefix' => 'statistics'], function () {
        Route::get('/', [StatisticsController::class, 'index'])->name('statistics');
    });
});



require __DIR__.'/auth.php';

