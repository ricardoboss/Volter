<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Console\Commands\FiltersUsers;
use App\Console\Commands\ShowModel;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\Output;

/**
 * Class Remove.
 */
class Remove extends Command
{
    use ShowModel, FiltersUsers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:remove
                                {filter : A value to filter the users by. Can be an ID or e-mail}
                                {--F|force : Force deletion of a user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a user based on one of their attributes.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = $this->getUser($this->argument("filter"));
        if ($user == null) {
            $this->info("No user was found.", Output::VERBOSITY_VERBOSE);

            return 1;
        }

        $this->info("You are about to delete this user:");
        $this->show($user, ['id', 'name', 'email', 'created_at']);

        if (!$this->option('force') && !$this->confirm('Do you really want to delete this user (irreversible)?')) {
            return 2;
        }

        $user->forceDelete();

        $this->info("User deleted successfully.");

        return 0;
    }
}
