<?php

namespace App\Policies;

use App\Models\Blog;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User        $user
     * @param \App\Models\Blog $blog
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function view(User $user, Blog $blog)
    {
        return $user->id === $blog->writer_id;
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
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User        $user
     * @param \App\Models\Blog $blog
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function update(User $user, Blog $blog)
    {
        return $user->id === $blog->writer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User        $user
     * @param \App\Models\Blog $blog
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function delete(User $user, Blog $blog)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User        $user
     * @param \App\Models\Blog $blog
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function restore(User $user, Blog $blog)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User        $user
     * @param \App\Models\Blog $blog
     *
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function forceDelete(User $user, Blog $blog)
    {
    }
}
