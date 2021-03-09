<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/user';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapAuthRoutes();

        $this->mapUserRoutes();

        $this->mapAdminRoutes();

        $this->mapApiRoutes();

        $this->mapGuestRoutes();

        $this->mapEmailRoutes();
    }

    /**
     * Define the "guest" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapGuestRoutes()
    {
        Route::middleware(['web'])
            ->namespace('App\Http\Controllers\Guest')
            ->name('guest.')
            ->group(base_path('routes/guest.php'));
    }

    /**
     * Define the "auth" routes for the application.
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::middleware(['web'])
            ->namespace('App\Http\Controllers\Auth')
            ->group(base_path('routes/auth.php'));
    }

    /**
     * Define the "user" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapUserRoutes()
    {
        Route::prefix('user')
            ->middleware(['web', 'auth:user', 'verified'])
            ->namespace('App\Http\Controllers\User')
            ->name('user.')
            ->group(base_path('routes/user.php'));
    }

    /**
     * Define the "admin" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web', 'auth:admin'])
            ->namespace('App\Http\Controllers\Admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "email" routes for the application.
     *
     * @return void
     */
    protected function mapEmailRoutes()
    {
        Route::prefix('email')
            ->middleware(['web', 'signed'])
            ->namespace('App\Http\Controllers\Email')
            ->name('emails.')
            ->group(base_path('routes/emails.php'));
    }

    /**
     * Define the "api" routes for the application.
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware(['api'])
            ->namespace('App\Http\Controllers\Api')
            ->name('api.')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
