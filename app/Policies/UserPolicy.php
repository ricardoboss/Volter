<?php

declare(strict_types=1);

/*
 * Copyright (C) 2019 Ricardo Boss
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

/**
 * Class UserPolicy.
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Whether a user can create another user.
     */
    public function create(User $user): Response
    {
        if ($user->hasPermission('user.create')) {
            return $this->allow("You can create users.");
        }

        return $this->deny("You are unauthorized to create users.");
    }

    /**
     * Whether a user can view another user.
     */
    public function view(User $user, User $subject): Response
    {
        if ($user->hasPermission('user.view.any') || $user->id === $subject->id) {
            return $this->allow("You can view this user.");
        }

        return $this->deny("You are unauthorized to view this user.");
    }

    /**
     * Whether a user can delete another user.
     */
    public function delete(User $user, User $subject): Response
    {
        if ($user->hasPermission('user.delete.any')) {
            return $this->allow("You can delete any user.");
        }

        if ($user->hasPermission('user.delete.self') && $user->id === $subject->id) {
            return $this->allow("You are allowed to delete your own account.");
        }

        return $this->deny("You are unauthorized to delete this user.");
    }

    /**
     * Whether a user can update another user.
     */
    public function update(User $user, User $subject): Response
    {
        if ($user->hasPermission('user.edit.any')) {
            return $this->allow("You can update any user.");
        }

        if ($user->hasPermission('user.edit.self') && $user->id === $subject->id) {
            return $this->allow("You are allowed to update your own account.");
        }

        return $this->deny("You are unauthorized to update this user.");
    }

    /**
     * Whether a user can promote another user to admin.
     */
    public function promote(User $user, User $subject): Response
    {
        if ($user->hasPermission('user.promote') && !$subject->hasRole('admin')) {
            return $this->allow("You can promote this user to admin.");
        }

        return $this->deny("You are unauthorized to promote this user to admin.");
    }

    /**
     * Whether a user can demote an admin to a user.
     */
    public function demote(User $user, User $subject): Response
    {
        if ($user->hasPermission('admin.demote') && $subject->hasRole('admin')) {
            return $this->allow("You can demote this user.");
        }

        return $this->deny("You are unauthorized to demote this user.");
    }
}
