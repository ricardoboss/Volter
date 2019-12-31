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
        $identifier = $this->argument('id');
        $u = User::where('id', $identifier)
            ->orWhere('email', $identifier)
            ->orWhere('name', $identifier)
            ->first();

        if ($u == null) {
            $this->error("Could not find user with id, email or name \"$identifier\"");

            return false;
        }

        $availableAttrs = get_model_attrs(User::class);

        $this->show($u, collect($availableAttrs)->except(['password'])->toArray());

        if (!$this->hasArgument('attribute') || !in_array($this->argument('attribute'), $availableAttrs)) {
            $attribute = $this->choice('Please choose an attribute to set', $availableAttrs);
        } else {
            $attribute = $this->argument('attribute');
        }

        $value = $this->argument('value') ?? $this->ask("New value of $attribute", $u->{$attribute});

        $u->{$attribute} = $value;
        $u->save();

        $this->info('User saved:');
        $this->show($u, collect($availableAttrs)->except('password')->toArray());

        return true;
    }
}
