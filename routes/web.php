<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HistoryController;
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

Route::get('event/detail/{slug}', [HistoryController::class, 'detailEvent'])->name('detail.event');


Route::group(['middleware' => 'auth'], function () {
    Route::delete('category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware('role:admin');
    Route::resource('category', CategoryController::class)->except('destroy', 'show')->middleware('role:admin');

    Route::get('event/history', [HistoryController::class, 'index'])->name('history')->middleware('permission:event history');

    Route::get('event/register/{slug}', [EventController::class, 'registerEvent'])->name('event.register');

    Route::view('setting', 'setting')->name('setting')->middleware('permission:setting');
});


Route::group(['middleware' => ['auth', 'role:organizer|admin']], function () {
    // event
    Route::delete('event/destroy', [EventController::class, 'destroy'])->name('event.destroy');

    Route::get('event/payment-valid/{transaction_code}', [EventController::class, 'updatePaymentStatus'])->name('event.update-payment-status');

    Route::get('event/check-payment-status', [EventController::class, 'checkPaymentStatus'])->name('event.check-payment-status');

    Route::resource('event', EventController::class)->except('destroy', 'updatePaymentStatus', 'registerEvent', 'checkPaymentStatus', 'history');


    // performer
    Route::delete('performer/destroy', [PerformerController::class, 'destroy'])->name('performer.destroy');

    Route::resource('performer', PerformerController::class)->except('destroy', 'show');
});
