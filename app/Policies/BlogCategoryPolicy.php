<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCategoryPolicy
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
        return $user->can('backend.blogCategories.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param BlogCategory $blogCategory
     * @return bool
     */
    public function view(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('backend.blogCategories.show');
    }

    /**
     * Determine whether the user can change status.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user): bool
    {
        return $user->can('backend.blogCategories.status');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('backend.blogCategories.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param BlogCategory $blogCategory
     * @return bool
     */
    public function update(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('backend.blogCategories.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param BlogCategory $blogCategory
     * @return bool
     */
    public function delete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('backend.blogCategories.destroy');
    }

    /**
     * Determine whether the user can view trash.
     *
     * @param User $user
     * @return bool
     */
    public function trash(User $user): bool
    {
        return $user->can('backend.blogCategories.trash');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('backend.blogCategories.restore');
    }

    /**
     * Determine whether the user can remove the model permanently.
     *
     * @param User $user
     * @return bool
     */
    public function remove(User $user): bool
    {
        return $user->can('backend.blogCategories.remove');
    }
}
