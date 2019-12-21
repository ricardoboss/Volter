<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Password;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class PasswordPolicy.
 */
class PasswordPolicy
{
    use HandlesAuthorization;

    /**
     * Whether a user can create a new password.
     */
    public function create(User $user): Response
    {
        if ($user->hasPermission('password.create')) {
            return $this->allow("You are able to create passwords.");
        }

        return $this->deny("You are unauthorized to create passwords.");
    }

    /**
     * Whether a user can update a password.
     */
    public function update(User $user, Password $password): Response
    {
        if ($user->hasPermission('password.edit.any')) {
            return $this->allow("You can edit any password.");
        }

        if ($user->hasPermission('password.edit.self') &&
            $password->created_by === $user->id) {
            return $this->allow("You can edit this password.");
        }

        $shared = DB::table('shared_access')
            ->where([
                'password_id' => $password->id,
                'model_type' => User::class,
                'model_id' => $user->id,
                'can_edit' => true,
            ])
            ->exists();

        if ($shared) {
            return $this->allow("This password was shared with you and you can edit it.");
        }

        return $this->deny("You are unauthorized to update this password.");
    }

    /**
     * Whether a user can delete a password.
     */
    public function delete(User $user, Password $password): Response
    {
        if ($user->hasPermission('password.delete.any')) {
            return $this->allow("You can delete any password.");
        }

        if ($user->hasPermission('password.delete.self') &&
            $password->created_by === $user->id) {
            return $this->allow("You can delete this password.");
        }

        return $this->deny("You are unauthorized to delete this password.");
    }

    /**
     * Whether a user can destroy (permanently delete) a password.
     */
    public function destroy(User $user, Password $password): Response
    {
        if ($user->hasPermission('password.destroy.any')) {
            return $this->allow("You can destroy any password.");
        }

        if ($user->hasPermission('password.destroy.self') &&
            $password->created_by === $user->id) {
            return $this->allow("You can destroy this password.");
        }

        return $this->deny("You are unauthorized to destroy this password.");
    }

    /**
     * Whether a user can list all passwords.
     */
    public function viewAll(User $user): Response
    {
        if ($user->hasPermission('password.view.any')) {
            return $this->allow("You can view any password.");
        }

        return $this->deny("You are unauthorized to view any password.");
    }

    /**
     * Whether a user can view a specific password.
     */
    public function view(User $user, Password $password): Response
    {
        if ($user->can('viewAll', Password::class)) {
            return $this->allow("You can view any password");
        }

        if ($user->hasPermission('password.view.self') &&
            $password->created_by === $user->id) {
            return $this->allow("You can view this password.");
        }

        $shared = DB::table('shared_access')
            ->where([
                'password_id' => $password->id,
                'model_type' => User::class,
                'model_id' => $user->id,
            ])
            ->exists();

        if ($shared) {
            return $this->allow("This password was shared with you.");
        }

        return $this->deny("You are unauthorized to view this password.");
    }

    /**
     * Whether a user can share a password.
     */
    public function share(User $user, Password $password): Response
    {
        if ($user->hasPermission('password.share.any')) {
            return $this->allow("You can share any password.");
        }

        if ($user->hasPermission('password.share.self') &&
            $password->created_by === $user->id) {
            return $this->allow("You can share this password.");
        }

        return $this->deny("You are unauthorized to share this password.");
    }
}
