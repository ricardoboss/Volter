<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Console\Commands\ShowModel;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\Output;

/**
 * Class Modify.
 */
class Modify extends Command
{
    use ShowModel;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:mod
                                {filter : A value to filter the users by. Can be an ID or e-mail}
                                {attribute? : The attribute to modify}
                                {value? : The new value of the attribute}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Modify an existing user.';

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): int
    {
        $user = $this->getUser();

        if ($user === null) {
            $this->warn('No user was found.', Output::VERBOSITY_VERBOSE);

            return 1;
        }

        // gather the column names which should be excluded from modifying
        $excludeCols = [
            $user->getKeyName(),            // primary key
            $user->getUpdatedAtColumn(),    // timestamp is automatically updated
            $user->getCreatedAtColumn(),    // should not be edited
            'password',                     // sensitive and hashed
            'remember_token',               // automatically generated, might be removed later
        ];

        // exclude fields which are not meant to be edited directly
        $availableAttrs = collect(get_table_cols(User::class))
            ->filter(function ($value) use ($excludeCols) {
                return !in_array($value, $excludeCols);
            })
            ->values()
            ->all();

        $userSaved = false;
        do {
            $this->info('About to modify this user:');
            $this->show($user, $availableAttrs);

            if (!$this->hasArgument('attribute') || !in_array($this->argument('attribute'), $availableAttrs)) {
                $attribute = $this->choice('Please choose an attribute to set', $availableAttrs);
            } else {
                $attribute = $this->argument('attribute');
            }

            $previousValue = $user->{$attribute};
            $value = $this->argument('value') ?? $this->ask("New value of $attribute", $previousValue);

            try {
                DB::beginTransaction();

                $user->{$attribute} = $value;
                $user->save();

                DB::commit();

                $userSaved = true;
            } catch (QueryException $e) {
                // Notice: DB::rollBack can throw an exception if no transaction was started before. This exception
                // is not handled here (but still mentioned in the docblock).
                DB::rollBack();

                $user->{$attribute} = $previousValue;

                if (Str::contains($e->getMessage(), 'Duplicate entry')) {
                    $message = "Value is already given to another user.";
                } else {
                    $message = $e->getMessage();
                }

                $this->error("Could not update user: $message");
                $this->info($e->getTraceAsString(), Output::VERBOSITY_DEBUG);

                if (!$this->confirm("Do you want to try again")) {
                    $this->warn("Changes not saved.");

                    return 2;
                }
            } catch (Exception $e) {
                $this->error("Could not update user: {$e->getMessage()}");
                $this->info($e->getTraceAsString(), Output::VERBOSITY_DEBUG);

                return 3;
            }
        } while (!$userSaved);

        $this->info('User saved:');
        $this->show($user, $availableAttrs);

        return 0;
    }

    /**
     * Try to get the user by the supplied filter argument.
     */
    private function getUser(): ?User
    {
        $identifier = $this->argument('filter');

        $users = User::where('id', $identifier)
            ->orWhere('email', 'LIKE', "%$identifier%");

        $count = $users->count();
        $this->info("Found $count user(s).", Output::VERBOSITY_VERBOSE);

        if ($count == 0) {
            $this->error("Could not find user with id or email \"$identifier\"");

            return null;
        }

        if ($count > 1 && $this->input->isInteractive()) {
            $choices = $users->get()
                ->map(function (User $user) {
                    return "Name: $user->name, E-Mail: $user->email, Created: $user->created_at, Id: $user->id";
                })
                ->all();

            $choice = $this->choice('Filter is ambiguous, found multiple users! Which user do you want to edit',
                $choices);

            $id = Str::after($choice, 'Id: ');
            $user = User::whereId($id)->first();
        } elseif ($count > 1) {
            $this->error("Filter is ambiguous! Found $count users that match the given filter \"$identifier\". Cannot continue without interaction.");

            return null;
        } else {
            $user = $users->first();
        }

        return $user;
    }
}
