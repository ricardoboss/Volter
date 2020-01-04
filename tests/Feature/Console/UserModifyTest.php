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

class UserModifyTest extends TestCase
{
    use RefreshDatabase;

    /** @var User|null */
    private $user;

    /** @noinspection MethodVisibilityInspection */
    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class, 10)->create();
        $this->user = factory(User::class)->create(['name' => "John Doe"]);
    }

    public function testInteractiveWithId(): void
    {
        $this->withInteractiveInput($this->user->id, "email", "john@example.com");
    }

    public function testStaticWithId(): void
    {
        $this->withStaticInput($this->user->id, "email", "john@example.com");
    }

    public function testStaticWithIdNonInteractive(): void
    {
        $this->withStaticInputNonInteractive($this->user->id, "email", "john@example.com");
    }

    public function testInteractiveWithEmail(): void
    {
        $this->withInteractiveInput($this->user->email, "name", "Jane Doe");
    }

    public function testStaticWithEmail(): void
    {
        $this->withStaticInput($this->user->email, "name", "Jane Doe");
    }

    public function testStaticWithEmailNonInteractive(): void
    {
        $this->withStaticInputNonInteractive($this->user->email, "name", "Jane Doe");
    }

    private function withInteractiveInput(string $filter, string $attr, string $value): void
    {
        $this->artisan("user:mod $filter")
            ->expectsOutput("About to modify this user:")
            ->expectsQuestion("Please choose an attribute to set", $attr)
            ->expectsQuestion("New value of $attr", $value)
            ->expectsOutput("User saved:")
            ->assertExitCode(0);

        $this->user->refresh();

        $this->assertEquals($value, $this->user->{$attr});
    }

    private function withStaticInput(string $filter, string $attr, string $value): void
    {
        $this->artisan("user:mod \"$filter\" \"$attr\" \"$value\"")
            ->expectsOutput("About to modify this user:")
            ->expectsOutput("User saved:")
            ->assertExitCode(0);

        $this->user->refresh();

        $this->assertEquals($value, $this->user->{$attr});
    }

    private function withStaticInputNonInteractive(string $filter, string $attr, string $value): void
    {
        $this->artisan("user:mod \"$filter\" \"$attr\" \"$value\" -n")
            ->expectsOutput("About to modify this user:")
            ->expectsOutput("User saved:")
            ->assertExitCode(0);

        $this->user->refresh();

        $this->assertEquals($value, $this->user->{$attr});
    }
}
