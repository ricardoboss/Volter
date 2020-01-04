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

namespace App\Console\Commands\User;

use App\Console\Commands\ShowModel;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;

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
                                {pass? : The password of the new user}
                                {--role=user : The role slug to attach to the new user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name') ?? $this->ask('Name');
        $email = $this->argument('email') ?? $this->ask('E-Mail Address');
        $password = $this->argument('pass') ?? $this->secret('Password (hidden)');
        $role_slug = $this->option('role');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);

        $user->save();
        $user->refresh();

        $role = Role::where('slug', $role_slug)->firstOrFail();
        $user->attachRole($role);

        $this->info("User created with role '{$role->name}':");
        $this->show($user, ['id', 'name', 'email', 'created_at']);
    }
}
