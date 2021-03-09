<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class AdminPolicy
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
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function view(User $user, Admin $admin)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function update(User $user, Admin $admin)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function delete(User $user, Admin $admin)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function restore(User $user, Admin $admin)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \Illuminate\Foundation\Auth\User $user
     * @param \App\Models\Admin $admin
     * @return mixed
     */
    public function forceDelete(User $user, Admin $admin)
    {
        return $user->isSuperAdmin();
    }
}
