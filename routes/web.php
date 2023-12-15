<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('payment/create', [PaymentController::class, 'createPayment'])->name('create.payment');

Route::post('callback', [PaymentController::class, 'callback'])->name('callback');

Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');