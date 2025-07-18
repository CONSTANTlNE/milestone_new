<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('backend.blogs.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function view(User $user, Blog $blog): bool
    {
        return $user->can('backend.blogs.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.blogs.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.blogs.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function update(User $user, Blog $blog): bool
    {
        return $user->can('backend.blogs.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function delete(User $user, Blog $blog): bool
    {
        return $user->can('backend.blogs.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.blogs.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.blogs.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.blogs.remove');
    }
}
