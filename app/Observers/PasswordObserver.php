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

namespace App\Observers;

use App\Models\Password;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Log;

/**
 * Class PasswordObserver.
 */
class PasswordObserver
{
    /**
     * Get the currently authenticated user.
     *
     * @throws AuthenticationException
     */
    private function getUser(): User
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user && !App::runningInConsole()) {
            throw new AuthenticationException();
        } elseif (App::runningInConsole()) {
            $user = User::first();

            assert($user != null, 'Must have at least one user available.');
        }

        return $user;
    }

    /**
     * Handle the password "creating" event.
     *
     * @throws AuthenticationException
     */
    public function creating(Password $password): void
    {
        $user = $this->getUser();

        $password->id = Str::uuid()->toString();
        $password->version = 0;

        // check if creator was already set
        if ($password->created_by == null) {
            $password->creator()->associate($user);
        }

        // check if editor was already set
        if ($password->updated_by == null) {
            $password->editor()->associate($user);
        }

        Log::info("User $user->name ($user->id) created password \"$password->name\" ($password->id).");
    }

    /**
     * Handle the password "updating" event.
     *
     * @throws AuthenticationException
     */
    public function updating(Password $password): void
    {
        $user = $this->getUser();

        // TODO: create backup of previous value

        $password->version++;
        $password->editor()->associate($user);

        Log::info("User $user->name ($user->id) updated password \"$password->name\" ($password->id) to version $password->version.");
    }

    /**
     * Handle the password "deleting" event.
     *
     * @throws AuthenticationException
     */
    public function deleting(Password $password): void
    {
        $user = $this->getUser();

        $password->deleter()->associate($user);

        Log::notice("User $user->name ($user->id) deleted password \"$password->name\" ($password->id).");
    }

    /**
     * Handle the password "restoring" event.
     *
     * @throws AuthenticationException
     */
    public function restoring(Password $password): void
    {
        $user = $this->getUser();

        Log::notice("User $user->name ($user->id) restored password \"$password->name\" ($password->id).");
    }

    /**
     * Handle the password "force deleted" event.
     *
     * @throws AuthenticationException
     */
    public function forceDeleted(Password $password): void
    {
        $user = $this->getUser();

        Log::warning("User $user->name ($user->id) destroyed password \"$password->name\" ($password->id) permanently.");
    }
}
