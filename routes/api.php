<?php

use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Expenses\ListExpensesController;
use Illuminate\Support\Facades\Route;

Route::get('/healthcheck', HealthCheckController::class);

Route::post('/register', RegisterController::class)->middleware('guest');
Route::post('/login', LoginController::class)->middleware('guest');
Route::post('/auth', AuthController::class)->middleware('guest');

Route::get('/user', MeController::class)->middleware('auth:sanctum');

Route::post('/logout', LogoutController::class)->middleware('auth:sanctum');

Route::get('/expenses', ListExpensesController::class)->middleware('auth:sanctum');
