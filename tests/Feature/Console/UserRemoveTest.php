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

class UserRemoveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class, 1)->create();
        factory(User::class)->create([
            'name' => "John Doe",
            'email' => "john@testing",
        ]);
    }

    public function testUnique(): void
    {
        $this->artisan('user:remove john@testing')
            ->expectsOutput("You are about to delete this user:")
            ->expectsQuestion("Do you really want to delete this user (irreversible)?", true)
            ->assertExitCode(0)
            ->run();

        $this->assertDatabaseMissing('users', ['email' => "john@testing"]);
    }

    public function testAbort(): void
    {
        $this->artisan('user:remove john@testing')
            ->expectsOutput("You are about to delete this user:")
            ->expectsQuestion("Do you really want to delete this user (irreversible)?", false)
            ->assertExitCode(2)
            ->run();

        $this->assertDatabaseHas('users', ['email' => "john@testing"]);
    }

    public function testForce(): void
    {
        $this->artisan('user:remove john@testing --force')
            ->expectsOutput("You are about to delete this user:")
            ->assertExitCode(0)
            ->run();

        $this->assertDatabaseMissing('users', ['email' => "john@testing"]);
    }
}
