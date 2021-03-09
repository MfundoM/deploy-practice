<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Current logged-in user.
     *
     * @param string $guard
     * @return \Illuminate\Contracts\Auth\Authenticatable|\App\Models\User|null
     */
    protected static function user(string $guard = 'user')
    {
        return auth($guard)->user() ?? null;
    }
}
