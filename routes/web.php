<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\media\HomeController;


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

Route::get('home', [HomeController::class, 'show']);
Route::get('/home/get_chart',[HomeController::class, 'get_chart']);

