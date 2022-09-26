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

Route::get('/tables',[TimeController::class,'index'])->name("timetable.home");
Route::put('/tables/{$id}',[TimeController::class,'update'])->name("timetable.update");
