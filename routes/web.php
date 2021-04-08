<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerformerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('category', CategoryController::class)->except('destroy', 'show');
    Route::delete('category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');

    // event
    Route::delete('event/destroy', [EventController::class, 'destroy'])->name('event.destroy');
    Route::get('event/register/{slug}', [EventController::class, 'registerEvent'])->name('event.register');

    Route::get('event/payment-valid/{transaction_code}', [EventController::class, 'updatePayment'])->name('event.update-payment');

    Route::get('event/check-payment-status', [EventController::class, 'checkPaymentStatus'])->name('event.check-payment-status-form');

    Route::resource('event', EventController::class)->except('destroy', 'updatePayment', 'registerEvent');

    // performer
    Route::resource('performer', PerformerController::class)->except('destroy', 'show');
    Route::delete('performer/destroy', [PerformerController::class, 'destroy'])->name('performer.destroy');

    Route::view('setting', 'setting')->name('setting');
});
