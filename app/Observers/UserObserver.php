<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
use RuntimeException;

/**
 * Class UserObserver
 *
 * @package App\Observers
 */
class UserObserver
{
    /**
     * Handle the user "created" event.
     */
    public function created(User $user): void
    {
        $roles = Role::query()->where('slug', 'user')->pluck('id')->toArray();
        if (count($roles) == 0)
            throw new RuntimeException("Default role with slug 'user' not found!");

        // assign default role
        $user->attachRole($roles[0]);
    }
}
