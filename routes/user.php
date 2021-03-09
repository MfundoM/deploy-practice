<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Routes for the signed-in User.
|
*/

Route::get('/', [\App\Http\Controllers\User\DashboardController::class, 'dashboard'])->name('dashboard');


Route::get('profile', [\App\Http\Controllers\User\UserController::class, 'show'])->name('profile.show');

Route::put('profile', [\App\Http\Controllers\User\UserController::class, 'update'])->name('profile.update');

Route::put('profile/password', [\App\Http\Controllers\User\UserController::class, 'password'])->name('profile.password');
