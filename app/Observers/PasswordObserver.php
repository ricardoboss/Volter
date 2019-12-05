<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\Password;
use App\Models\User;
use Illuminate\Support\Str;
use Log;

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
        /** @var User $user */
        $user = auth()->user();

        $password->{$password->getKeyName()} = Str::uuid()->toString();
        $password->created_by = $user->id;

        Log::info("User {$user->name} created password \"{$password->name}\" ({$password->id}).");
    }

    /**
     * Handle the password "updating" event.
     */
    public function updating(Password $password): void
    {
        /** @var User $user */
        $user = auth()->user();

        // TODO: create backup of previous value

        $password->version++;
        $password->updated_by = $user->id;

        Log::info("User {$user->name} updated password \"{$password->name}\" ({$password->id}) to version {$password->version}.");
    }

    /**
     * Handle the password "deleting" event.
     */
    public function deleting(Password $password): void
    {
        /** @var User $user */
        $user = auth()->user();

        $password->deleted_by = $user->id;

        Log::notice("User {$user->name} deleted password \"{$password->name}\" ({$password->id}).");
    }

    /**
     * Handle the password "restoring" event.
     */
    public function restoring(Password $password): void
    {
        $password->deleted_by = null;

        /** @var User $user */
        $user = auth()->user();

        Log::notice("User {$user->name} restored password \"{$password->name}\" ({$password->id}).");
    }

    /**
     * Handle the password "force deleted" event.
     */
    public function forceDeleted(Password $password): void
    {
        /** @var User $user */
        $user = auth()->user();

        Log::warning("User {$user->name} destroyed password \"{$password->name}\" ({$password->id}) permanently.");
    }
}
