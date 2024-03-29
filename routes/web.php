<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tables',[TimeController::class,'index'])->name("home");
Route::get('/tables/{courseName}',[TimeController::class,'countUpdate'])->name("update");
Route::get('setup', [TimeController::class, 'setup'])->name("setup");
