<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Console\Commands\ShowModel;
use App\Models\User;
use Illuminate\Console\Command;

/**
 * Class Remove.
 */
class Remove extends Command
{
    use ShowModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:remove
                                {attribute : The attribute to filter by}
                                {value : The value of the attribute to filter by}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a user based on one of their attributes.';

    /**
     * Execute the console command.
     */
    public function handle(): bool
    {
        $availableAttrs = get_model_attrs(User::class);
        $user = User::where($this->argument('attribute'), $this->argument('value'))->first();

        while ($user == null) {
            $this->error('No user found!');

            $attribute = $this->choice('Select one of these attributes', $availableAttrs);
            $value = $this->ask('Value of attribute');

            $user = User::where($attribute, $value)->first();
        }

        $id = $user->id;

        $this->show($user, ['id', 'name', 'email', 'created_at']);
        if (!$this->confirm('Do you really want to delete this user (irreversible)?')) {
            return false;
        }

        $user->forceDelete();

        $this->info("User with id $id deleted.");

        return true;
    }
}
