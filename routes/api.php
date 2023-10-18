<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});


Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'user']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::put('/change-password', [UserController::class, 'changePassword']);
    Route::put('/bank', [UserController::class, 'updateBankDetails']);
    Route::put('/update-address', [UserController::class, 'updateAddress']);
    Route::get('/platform-settings', [UserController::class, 'getPlatformSettings']);
});

// Route::get

// order controller

Route::middleware('auth:sanctum')->prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('create/{type}', [OrderController::class, 'store']);
    Route::get('{order}', [OrderController::class, 'show']);
});
