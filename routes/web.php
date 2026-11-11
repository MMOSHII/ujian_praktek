<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductApiController;

Route::inertia('/', 'Welcome')->name('home');

Route::resource('/dashboard', DashboardController::class)
        ->middleware(['auth'])
        ->parameters(['dashboard' => 'product']);

Route::apiResource('products', ProductApiController::class);

require __DIR__.'/settings.php';
