<?php

use App\Http\Controllers\MethodController;
use App\Http\Controllers\MonthController;
use App\Http\Controllers\ScheduleController;
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
    return (new ScheduleController)->index();
});

Route::get('schedules', [ScheduleController::class, 'index']);
Route::get('get-schedules', [ScheduleController::class, 'getindex']);
Route::post('add-update-schedule', [ScheduleController::class, 'store']);
Route::post('edit-schedule', [ScheduleController::class, 'edit']);
Route::post('delete-schedule', [ScheduleController::class, 'destroy']);

Route::post('add-update-month', [MonthController::class, 'store']);
Route::post('edit-month', [MonthController::class, 'edit']);
Route::post('delete-month', [MonthController::class, 'destroy']);

Route::post('add-update-method', [MethodController::class, 'store']);
Route::post('edit-method', [MethodController::class, 'edit']);
Route::post('delete-method', [MethodController::class, 'destroy']);
