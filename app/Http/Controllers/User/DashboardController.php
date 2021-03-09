<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }
}
