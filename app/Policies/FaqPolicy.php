<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Faq;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
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
        return $user->can('backend.faqs.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Faq $faq
     * @return bool
     */
    public function view(User $user, Faq $faq): bool
    {
        return $user->can('backend.faqs.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.faqs.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.faqs.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Faq $faq
     * @return bool
     */
    public function update(User $user, Faq $faq): bool
    {
        return $user->can('backend.faqs.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Faq $faq
     * @return bool
     */
    public function delete(User $user, Faq $faq): bool
    {
        return $user->can('backend.faqs.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.faqs.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.faqs.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.faqs.remove');
    }
}
