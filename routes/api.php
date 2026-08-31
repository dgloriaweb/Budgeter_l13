<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\AccountController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    // Route::get('/get_accounts', [AccountController::class, 'index']);
});

Route::get('/healthcheck', HealthCheckController::class); // stays public, outside the group