<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\Output;

/**
 * Trait FiltersUsers
 *
 * @mixin Command
 */
trait FiltersUsers
{
    /**
     * Try to get the user by the supplied filter argument.
     */
    private function getUser(string $filter): ?User
    {
        $users = User::where('id', $filter)
            ->orWhere('email', 'LIKE', "%$filter%");

        $count = $users->count();
        $this->info("Found $count user(s).", Output::VERBOSITY_VERBOSE);

        if ($count == 0) {
            $this->error("Could not find user with id or email \"$filter\"");

            return null;
        }

        if ($count > 1 && $this->input->isInteractive()) {
            $choices = $users->get()
                ->map(function (User $user) {
                    return "Name: $user->name, E-Mail: $user->email, Created: $user->created_at, Id: $user->id";
                })
                ->all();

            $choice = $this->choice('Filter is ambiguous, found multiple users! Please choose a user',
                $choices);

            $id = Str::after($choice, 'Id: ');
            $user = User::whereId($id)->first();
        } elseif ($count > 1) {
            $this->error("Filter is ambiguous! Found $count users that match the given filter \"$filter\". Cannot continue without interaction.");

            return null;
        } else {
            $user = $users->first();
        }

        return $user;
    }
}
