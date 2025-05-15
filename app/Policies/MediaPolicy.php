<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
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
        return $user->can('backend.medias.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.medias.status');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('backend.medias.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.medias.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('backend.medias.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('backend.medias.destroy');
    }

    /**
     * Determine whether the user can remove the model, this is fast remove.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.medias.trash');
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.medias.restore');
    }
    /**
     * Determine whether the user can remove the model, this is fast remove.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.medias.remove');
    }
    /**
     * Determine whether the user can remove the model, this is fast remove.
     *
     * @param User $user
     * @return bool
     */
    public function position(User $user): bool
    {
        return $user->can('backend.medias.position');
    }
}
