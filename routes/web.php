<?php

use App\Http\Controllers\WaiterController;
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

Route::controller(WaiterController::class)->group(function () {
    Route::get('/login', 'getLoginPage')->name('waiterLogin');
    Route::post('/login', 'postLogin');
    Route::get('/logout', 'getLogout')->name('waiterLogout');
    Route::get('/dashboard','getDashboardPage')->name('waiterDashboard');
    Route::post('/dashboard', 'postDashboard');
});
