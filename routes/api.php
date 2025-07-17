<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/create', [UserController::class, 'create']);
    Route::get('/get/filter', [UserController::class, 'getByFilter']);
});