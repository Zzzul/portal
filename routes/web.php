<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\PerformerController;

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

Route::get('event/{slug}/detail', [EventController::class, 'detailEvent'])->name('event.detail');

Route::group(['middleware' => 'auth', 'role:organizer|admin|audience'], function () {
    Route::get('event/history', [EventController::class, 'index'])
        ->name('history')
        ->middleware('permission:event history');

    Route::get('event/{slug}/book', [EventController::class, 'bookEvent'])
        ->name('event.book')
        ->middleware('permission:event book');

    Route::view('setting', 'setting')
        ->name('setting')
        ->middleware('permission:setting');
});

Route::group(['middleware' => ['auth', 'role:organizer|admin']], function () {
    // event
    Route::delete('event/destroy', [OrganizerEventController::class, 'destroy'])
        ->name('event.destroy')
        ->middleware('permission:event delete');

    Route::get('event/payment-valid/{transaction_code}', [OrganizerEventController::class, 'updatePaymentStatus'])
        ->name('event.update-payment-status')
        ->middleware('permission:event update payment status');

    Route::get('event/check-payment-status', [OrganizerEventController::class, 'checkPaymentStatus'])
        ->name('event.check-payment-status')
        ->middleware('permission:event check payment status');

    Route::delete('performer/destroy', [PerformerController::class, 'destroy'])
        ->name('performer.destroy')
        ->middleware('permission:performer delete');

    Route::resource('event', OrganizerEventController::class)
        ->except('destroy', 'updatePaymentStatus', 'registerEvent', 'checkPaymentStatus', 'history');

    Route::resource('performer', PerformerController::class)
        ->except('destroy', 'show');
});

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
    Route::delete('category/destroy', [CategoryController::class, 'destroy'])
        ->name('category.destroy')
        ->middleware('permission:category delete');

    Route::resource('category', CategoryController::class)
        ->except('destroy', 'show');

    Route::resource('user', UserController::class)
        ->except('destroy', 'show', 'create');
});
