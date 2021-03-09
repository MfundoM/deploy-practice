<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->first_name = ucwords($user->first_name);
        $user->last_name = ucwords($user->last_name);
        $user->avatar = $user->avatar ?? $user->gravatar();

        do {
            $user->api_token = Str::random(60);
        } while (User::where('api_token', $user->api_token)->exists());
    }

    /**
     * Handle the user "created" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updating" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function updating(User $user)
    {
        $user->first_name = ucwords($user->first_name);
        $user->last_name = ucwords($user->last_name);
        $user->avatar = $user->avatar ?? $user->gravatar();
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleting" event.
     *
     * @param \App\Models\User $user
     * @return void|bool
     */
    public function deleting(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
