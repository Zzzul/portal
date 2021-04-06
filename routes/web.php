<?php

use App\Http\Controllers\CategoryController;
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

Route::view('/', 'home')->name('home');
Route::view('home', 'home')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('category', CategoryController::class)->except('destroy', 'show');
    Route::delete('/category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::view('setting', 'setting')->name('setting');
});
