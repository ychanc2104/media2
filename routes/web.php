<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\media\HomeController;
use App\Http\Controllers\media\DailyReportController;
use App\Http\Controllers\media\ADController;


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

Route::get('/login', function () {
    return view('login');
});

// Route::get('/pg1', function () {
//     return view('pg1');
// });

// Route::get('/2', function () {
//     return view('welcome2');
// });

Route::get('/home', [HomeController::class, 'home']);
Route::get('/home/get_chart_total_data',[HomeController::class, 'transmit_chart_total_data']);
Route::get('daily_report', [DailyReportController::class, 'daily_report']);
Route::get('daily_report/data', [DailyReportController::class, 'transmit_daily_report']);
Route::get('/create_ad', [ADController::class, 'index']);


