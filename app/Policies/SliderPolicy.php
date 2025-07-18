<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Slider;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
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
        return $user->can('backend.sliders.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Slider $slider
     * @return bool
     */
    public function view(User $user, Slider $slider): bool
    {
        return $user->can('backend.sliders.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.sliders.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.sliders.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Slider $slider
     * @return bool
     */
    public function update(User $user, Slider $slider): bool
    {
        return $user->can('backend.sliders.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Slider $slider
     * @return bool
     */
    public function delete(User $user, Slider $slider): bool
    {
        return $user->can('backend.sliders.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.sliders.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.sliders.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.sliders.remove');
    }
}
