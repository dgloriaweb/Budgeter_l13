<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::get('/docs', function () {
    return ['and why do not you just fuck off?'];
});
require __DIR__.'/auth.php';
