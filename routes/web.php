<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\DateController
;
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


Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::resources([
        'invoices' => InvoicesController::class,
        'customers' => CustomersController::class,
        'settings/taxs' => TaxController::class,
        'settings/days' => DateController::class
    ]);
});
