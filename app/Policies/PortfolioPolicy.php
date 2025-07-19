<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
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
        return $user->can('backend.portfolios.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Portfolio $portfolio
     * @return bool
     */
    public function view(User $user, Portfolio $portfolio): bool
    {
        return $user->can('backend.portfolios.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.portfolios.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.portfolios.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Portfolio $portfolio
     * @return bool
     */
    public function update(User $user, Portfolio $portfolio): bool
    {
        return $user->can('backend.portfolios.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Portfolio $portfolio
     * @return bool
     */
    public function delete(User $user, Portfolio $portfolio): bool
    {
        return $user->can('backend.portfolios.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.portfolios.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.portfolios.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.portfolios.remove');
    }
}
