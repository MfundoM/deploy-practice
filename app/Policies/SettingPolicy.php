<?php

namespace App\Policies;

use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Setting $setting
     * @return mixed
     */
    public function view(User $user, Setting $setting)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Setting $setting
     * @return mixed
     */
    public function update(User $user, Setting $setting)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Setting $setting
     * @return mixed
     */
    public function delete(User $user, Setting $setting)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Setting $setting
     * @return mixed
     */
    public function restore(User $user, Setting $setting)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Setting $setting
     * @return mixed
     */
    public function forceDelete(User $user, Setting $setting)
    {
        return false;
    }
}
