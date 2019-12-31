<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Console\Commands\ShowModel;
use App\Models\User;
use Illuminate\Console\Command;

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
                                {user : The ID of the user}
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
     */
    public function handle(): bool
    {
        $identifier = $this->argument('user');

        /** @var User $user */
        $user = User::where('id', $identifier)
            ->orWhere('email', $identifier)
            ->orWhere('name', $identifier)
            ->first();

        if ($user == null) {
            $this->error("Could not find user with id, email or name \"$identifier\"");

            return false;
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

        $this->show($user, $availableAttrs);

        if (!$this->hasArgument('attribute') || !in_array($this->argument('attribute'), $availableAttrs)) {
            $attribute = $this->choice('Please choose an attribute to set', $availableAttrs);
        } else {
            $attribute = $this->argument('attribute');
        }

        $value = $this->argument('value') ?? $this->ask("New value of $attribute", $user->{$attribute});

        $user->{$attribute} = $value;
        $user->save();

        $this->info('User saved:');
        $this->show($user, collect($availableAttrs)->except('password')->toArray());

        return true;
    }
}
