<?php

namespace App\Http\Controllers\Email;

use App\Helpers\Alert;
use App\Models\User;

class EmailController
{
    /**
     * Subscribe a user to receive emails.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe(User $user)
    {
        $user->forceFill(['subscribed' => true])->save();

        Alert::success('Subscribed successfully!');

        return redirect()->route('guest.homepage');
    }

    /**
     * Unsubscribe a user from receiving emails.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe(User $user)
    {
        $user->forceFill(['subscribed' => false])->save();

        Alert::success('Unsubscribed successfully!');

        return redirect()->route('guest.homepage');
    }
}
