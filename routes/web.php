<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'CheckType:user'],function(){ 
   Route::post('/home', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
});

Route::group(['middleware' => 'CheckType:admin'],function(){ 
    Route::post('/admin', [App\Http\Controllers\AttendanceController::class, 'find'])->name('attendance.find');
 });
 