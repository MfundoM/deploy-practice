<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes for the API.
|
*/

Route::get('user', [\App\Http\Controllers\Api\UserController::class, 'self'])->name('users.self');
