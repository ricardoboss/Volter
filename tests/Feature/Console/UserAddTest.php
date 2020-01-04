<?php

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

namespace Tests\Feature\Console;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAddTest extends TestCase
{
    use RefreshDatabase;

    public function testNoArgs(): void
    {
        $this->artisan('user:add')
            ->expectsQuestion('Name', 'John Doe')
            ->expectsQuestion('E-Mail Address', 'test@example.com')
            ->expectsQuestion('Password (hidden)', 'password')
            ->expectsOutput('User created with role \'User\':')
            ->assertExitCode(0);

        $this->checkUserExists();
    }

    public function testRoleOption(): void
    {
        $this->artisan('user:add --role=admin')
            ->expectsQuestion('Name', 'John Doe')
            ->expectsQuestion('E-Mail Address', 'test@example.com')
            ->expectsQuestion('Password (hidden)', 'password')
            ->expectsOutput('User created with role \'Admin\':')
            ->assertExitCode(0);

        $this->checkUserExists('admin');
    }

    public function testAllArguments(): void
    {
        $this->artisan('user:add "John Doe" test@example.com password')
            ->expectsOutput('User created with role \'User\':')
            ->assertExitCode(0);

        $this->checkUserExists();
    }

    private function checkUserExists(string $role = 'user'): void
    {
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);

        $user = User::whereEmail('test@example.com')->first();

        $this->assertTrue($user->hasRole($role));
    }
}
