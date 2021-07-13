<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\media\LoginController;
use App\Http\Controllers\media\HomeController;
use App\Http\Controllers\media\DailyReportController;
use App\Http\Controllers\media\ADController;
use App\Http\Controllers\AdKey\AdKeyController;
use App\Http\Controllers\AdKey\CompareGAController;


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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/post-login', [LoginController::class, 'postLogin'])->name('login.post');
Route::get('/clear/session', [LoginController::class, 'clearSessionKey'])->name('clear.session.key');



Route::get('/home', [HomeController::class, 'home'])->name('home')
    ->middleware(['login.required']);
Route::get('/home/get_chart_total_data',[HomeController::class, 'transmit_chart_total_data'])->name('chart.total.data');

Route::get('daily_report', [DailyReportController::class, 'daily_report'])->name('daily.report')
    ->middleware(['login.required']);
Route::get('daily_report/data', [DailyReportController::class, 'transmit_daily_report'])->name('daily.report.data');

Route::get('/create_ad', [ADController::class, 'index']);
Route::get('/ad_demo', [AdKeyController::class, 'index']);

Route::get('/test_1', [AdKeyController::class, 'test_1'])->name('test_1');
Route::get('/test_2', [AdKeyController::class, 'test_2'])->name('test_2');




Route::get('/render_url', [AdKeyController::class, 'render_ad_url']);

Route::get('/count_click', [CompareGAController::class, 'count_click'])->name('count.click');

// Route::get('/login/account', [LoginController::class, 'get_account']);


// Route::get('/pg1', function () {
//     return view('pg1');
// });

// Route::get('/2', function () {
//     return view('welcome2');
// });
