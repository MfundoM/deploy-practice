<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Email Routes
|--------------------------------------------------------------------------
|
| Routes for the (signed) emails.
|
*/

Route::prefix('subscription')->name('subscription.')->group(function () {

    Route::get('{user}/subscribe', [\App\Http\Controllers\Email\EmailController::class, 'subscribe'])->name('subscribe');

    Route::match(['GET', 'POST'], '{user}/unsubscribe', [\App\Http\Controllers\Email\EmailController::class, 'unsubscribe'])->name('unsubscribe');

});
