<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroqController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/create', [UserController::class, 'create']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::put('/update', [AuthController::class, 'update']);
    Route::delete('/delete', [AuthController::class, 'delete']);
});

Route::prefix('product')->group(function () {
    Route::post('/store', [ProductController::class, 'store']);
    Route::get('/get/filter', [ProductController::class, 'index']);

    Route::put('/update/{id}', [ProductController::class, 'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'delete']);

    Route::post('/virtual-assistance', [GroqController::class, 'askGroq']);
});