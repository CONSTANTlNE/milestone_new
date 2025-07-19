<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ServiceCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceCategoryPolicy
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
        return $user->can('backend.serviceCategories.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param ServiceCategory $serviceCategory
     * @return bool
     */
    public function view(User $user, ServiceCategory $serviceCategory): bool
    {
        return $user->can('backend.serviceCategories.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.serviceCategories.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.serviceCategories.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param ServiceCategory $serviceCategory
     * @return bool
     */
    public function update(User $user, ServiceCategory $serviceCategory): bool
    {
        return $user->can('backend.serviceCategories.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param ServiceCategory $serviceCategory
     * @return bool
     */
    public function delete(User $user, ServiceCategory $serviceCategory): bool
    {
        return $user->can('backend.serviceCategories.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.serviceCategories.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.serviceCategories.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.serviceCategories.remove');
    }
}
