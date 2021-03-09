<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for the Admin.
|
*/

Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
