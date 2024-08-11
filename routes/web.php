<?php

use App\Http\Controllers\BillplzController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PasswordController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [PasswordController::class, 'generate'])->name('password.generate');

    Route::resource('pizza', PizzaController::class);
    Route::get('/order/{order:order_id}/pay', [BillplzController::class, 'redirect'])->name('order.pay');
    Route::get('/order/{order:order_id}/completed', [PizzaController::class, 'completed'])->name('order.completed');
    Route::get('/order/{order}/failed', [PizzaController::class, 'failed'])->name('order.failed');

    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{order:order_id}/print', [OrderController::class, 'printBill'])->name('order.print');
});

Route::get('/billplz/return', [BillplzController::class, 'return'])->name('billplz.return');
Route::post('/billplz/callback', [BillplzController::class, 'callback'])->name('billplz.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
