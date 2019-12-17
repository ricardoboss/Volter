<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy.
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Whether a user can create another user.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('user.create');
    }

    /**
     * Whether a user can view another user.
     */
    public function view(User $user, User $subject): bool
    {
        return $user->hasPermission('user.view.any') ||
            $user->id === $subject->id;
    }

    /**
     * Whether a user can delete another user.
     */
    public function delete(User $user, User $subject): bool
    {
        if ($user->hasPermission('user.delete.any')) {
            return true;
        }

        if ($user->hasPermission('user.delete.self') &&
            $user->id === $subject->id) {
            return true;
        }

        return false;
    }

    /**
     * Whether a user can edit another user.
     */
    public function edit(User $user, User $subject): bool
    {
        if ($user->hasPermission('user.edit.any')) {
            return true;
        }

        if ($user->hasPermission('user.edit.self') &&
            $user->id === $subject->id) {
            return true;
        }

        return false;
    }

    /**
     * Whether a user can promote another user to admin.
     */
    public function promote(User $user, User $subject): bool
    {
        return $user->hasPermission('user.promote') && !$subject->hasRole('admin');
    }

    /**
     * Whether a user can demote an admin to a user.
     */
    public function demote(User $user, User $subject): bool
    {
        return $user->hasPermission('admin.demote') && $subject->hasRole('admin');
    }
}
