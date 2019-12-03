<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\Password;
use Illuminate\Support\Str;

/**
 * Class PasswordObserver
 * @package App\Observers
 */
class PasswordObserver
{
    /**
     * Handle the password "creating" event.
     */
    public function creating(Password $password): void
    {
        $password->{$password->getKeyName()} = Str::uuid()->toString();
    }

    /**
     * Handle the password "updating" event.
     */
    public function updating(Password $password): void
    {
        $password->version++;
    }

    /**
     * Handle the password "deleting" event.
     */
    public function deleting(Password $password): void
    {
        // TODO: set deleted_by to authenticated user or explicit user?
        $password->deleted_by = auth()->user()->getAuthIdentifier();
    }

    /**
     * Handle the password "restoring" event.
     */
    public function restoring(Password $password): void
    {
        $password->deleted_by = null;
    }

    /**
     * Handle the password "force deleting" event.
     */
    public function forceDeleting(Password $password): void
    {
        //
    }
}
