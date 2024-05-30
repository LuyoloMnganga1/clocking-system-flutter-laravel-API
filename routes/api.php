<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClockingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClockingReportController;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::post('password/reset', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('password/reset/confirm', [PasswordResetController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('clock-in', [ClockingController::class, 'clockIn']);
    Route::post('clock-out', [ClockingController::class, 'clockOut']);
    Route::get('clockings/check/{id}', [ClockingController::class, 'checkClockInStatus']);
    Route::get('clockings/weekly/{id}', [ClockingController::class, 'getWeeklyClockings']);
    Route::get('report', [ClockingReportController::class, 'getReport'])->middleware('admin');
    Route::get('export-report', [ClockingReportController::class, 'exportReport'])->middleware('admin');

});
