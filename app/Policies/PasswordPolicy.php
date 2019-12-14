<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\Password;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

/**
 * Class PasswordPolicy
 *
 * @package App\Policies
 */
class PasswordPolicy
{
    use HandlesAuthorization;

    // TODO: take shared access into account

    /**
     * Whether a user can create a new password.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('password.create');
    }

    /**
     * Whether a user can edit a password.
     */
    public function edit(User $user, Password $password): bool
    {
        if ($user->hasPermission('password.edit.any'))
            return true;

        if ($user->hasPermission('password.edit.self') &&
            $password->created_by === $user->id)
            return true;

        return DB::table('shared_access')
            ->where([
                'password_id' => $password->id,
                'model_type' => User::class,
                'model_id' => $user->id,
                'can_edit' => true,
            ])
            ->exists();
    }

    /**
     * Whether a user can delete a password.
     */
    public function delete(User $user, Password $password): bool
    {
        if ($user->hasPermission('password.delete.any'))
            return true;

        if ($user->hasPermission('password.delete.self') &&
            $password->created_by === $user->id)
            return true;

        return false;
    }

    /**
     * Whether a user can destroy (permanently delete) a password.
     */
    public function destroy(User $user, Password $password): bool
    {
        if ($user->hasPermission('password.destroy.any'))
            return true;

        if ($user->hasPermission('password.destroy.self') &&
            $password->created_by === $user->id)
            return true;

        return false;
    }

    /**
     * Whether a user can list all passwords.
     */
    public function viewAll(User $user): bool
    {
        return $user->hasPermission('password.view.any');
    }

    /**
     * Whether a user can view a specific password.
     */
    public function view(User $user, Password $password): bool
    {
        if ($user->can('viewAll', Password::class))
            return true;

        if ($user->hasPermission('password.view.self') &&
            $password->created_by === $user->id)
            return true;

        return false;
    }

    /**
     * Whether a user can share a password.
     */
    public function share(User $user, Password $password): bool
    {
        if ($user->hasPermission('password.share.any'))
            return true;

        if ($user->hasPermission('password.share.self') &&
            $password->created_by === $user->id)
            return true;

        return false;
    }
}
