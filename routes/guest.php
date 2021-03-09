<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Routes for the fronted / guests.
|
*/

Route::get('/', [\App\Http\Controllers\Guest\GuestController::class, 'homepage'])->name('homepage');


Route::get('about', [\App\Http\Controllers\Guest\GuestController::class, 'about'])->name('about');

Route::get('contact', [\App\Http\Controllers\Guest\GuestController::class, 'contact'])->name('contact');

Route::post('contact', [\App\Http\Controllers\Guest\GuestController::class, 'submitContact']);


Route::get('test', [\App\Http\Controllers\Guest\GuestController::class, 'test'])->name('test');
