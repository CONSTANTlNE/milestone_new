<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
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
        return $user->can('backend.pages.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Page $page
     * @return bool
     */
    public function view(User $user, Page $page): bool
    {
        return $user->can('backend.pages.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.pages.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.pages.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Page $page
     * @return bool
     */
    public function update(User $user, Page $page): bool
    {
        return $user->can('backend.pages.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Page $page
     * @return bool
     */
    public function delete(User $user, Page $page): bool
    {
        return $user->can('backend.pages.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.pages.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.pages.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.pages.remove');
    }
}
