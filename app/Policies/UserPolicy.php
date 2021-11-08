<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function viewAny()
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function view(User $user, User $model)
    {
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User        $user
     * @param \App\Models\User $model
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function update(User $user, User $model)
    {
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User        $user
     * @param \App\Models\User $model
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function delete(User $user, User $model)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User        $user
     * @param \App\Models\User $model
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function restore(User $user, User $model)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User        $user
     * @param \App\Models\User $model
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function forceDelete(User $user, User $model)
    {
    }
}
