<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed|void
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $uri = $request->getRequestUri();

            if (class_exists('\Laravel\Nova\Nova') && strpos($uri, config('nova.path')) === 0) {
                return url(config('nova.path'));

            } else if (strpos($uri, '/admin') === 0 && Route::has('admin.login')) {
                return route('admin.login');
            }

            return Route::has('login') ? route('login') : url('/');
        }
    }
}
