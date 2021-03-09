<?php

namespace App\Observers;

use App\Models\Admin;
use Illuminate\Support\Str;

class AdminObserver
{
    /**
     * Handle the admin "creating" event.
     *
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function creating(Admin $admin)
    {
        $admin->avatar = $admin->avatar ?? $admin->gravatar();

        do {
            $admin->api_token = Str::random(60);
        } while (Admin::where('api_token', $admin->api_token)->exists());
    }

    /**
     * Handle the admin "created" event.
     *
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function created(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "updating" event.
     *
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function updating(Admin $admin)
    {
        $admin->avatar = $admin->avatar ?? $admin->gravatar();
    }

    /**
     * Handle the admin "updated" event.
     *
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function updated(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "deleting" event.
     *
     * @param \App\Models\Admin $admin
     * @return void|bool
     */
    public function deleting(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "deleted" event.
     *
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function deleted(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "restored" event.
     *
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function restored(Admin $admin)
    {
        //
    }

    /**
     * Handle the admin "force deleted" event.
     *
     * @param \App\Models\Admin $admin
     * @return void
     */
    public function forceDeleted(Admin $admin)
    {
        //
    }
}
