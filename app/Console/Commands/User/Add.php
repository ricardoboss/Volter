<?php

declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Console\Commands\ShowModel;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Class Add.
 */
class Add extends Command
{
    use ShowModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add
                            {name? : The name of the new user}
                            {email? : The email address of the new user}
                            {pass? : The password of the new user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $this->ask('Name');
        $email = $this->argument('email') ?? $this->ask('E-Mail Address');
        $password = $this->argument('pass') ?? $this->secret('Password (hidden)');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);

        $user->save();
        $user->refresh();

        $this->info('User created:');
        $this->show($user, ['id', 'name', 'email', 'created_at']);

        return 0;
    }
}
