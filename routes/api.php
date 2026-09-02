<?php

use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/healthcheck', HealthCheckController::class);

Route::post('/register', RegisterController::class)->middleware('guest');
Route::post('/login', LoginController::class)->middleware('guest');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');
