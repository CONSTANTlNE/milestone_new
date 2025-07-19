<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
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
        return $user->can('backend.services.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Service $service
     * @return bool
     */
    public function view(User $user, Service $service): bool
    {
        return $user->can('backend.services.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.services.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.services.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Service $service
     * @return bool
     */
    public function update(User $user, Service $service): bool
    {
        return $user->can('backend.services.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Service $service
     * @return bool
     */
    public function delete(User $user, Service $service): bool
    {
        return $user->can('backend.services.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.services.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.services.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.services.remove');
    }
}
