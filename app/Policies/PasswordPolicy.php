<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\Password;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PasswordPolicy
 *
 * @package App\Policies
 */
class PasswordPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Whether a user can create a new password.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('password.create');
    }

    /**
     * Whether a user can view a password.
     */
    public function list(User $user, Password $password): bool
    {
        if ($user->hasPermission('password.view.any'))
            return true;

        if ($user->hasPermission('password.view.self') &&
            $password->created_by === $user->id)
            return true;

        return false;
    }
}
