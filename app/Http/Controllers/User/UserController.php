<?php

namespace App\Http\Controllers\User;

use App\Helpers\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\UserRequest;

class UserController extends Controller
{
    /**
     * Show user profile.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        $user = self::user();

        return view('user.profile')->with(compact('user'));
    }

    /**
     * Update user details.
     *
     * @param \App\Http\Requests\User\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request)
    {
        $updated = self::user()->update($request->validated());

        Alert::crud(!!$updated, 'update', 'profile');

        return redirect()->route('user.profile.show');
    }

    /**
     * Update user password.
     *
     * @param \App\Http\Requests\User\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        $updated = self::user()->update($request->validated());

        Alert::crud(!!$updated, 'update', 'password');

        return redirect()->route('user.profile.show');
    }
}
