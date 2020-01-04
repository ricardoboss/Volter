<?php

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
            'email' => "john@testing"
        ]);
    }

    public function testUnique() {
        $this->artisan('user:remove john@testing')
            ->expectsOutput("You are about to delete this user:")
            ->expectsQuestion("Do you really want to delete this user (irreversible)?", true)
            ->assertExitCode(0)
            ->run();

        $this->assertDatabaseMissing('users', ['email' => "john@testing"]);
    }

    public function testAbort() {
        $this->artisan('user:remove john@testing')
            ->expectsOutput("You are about to delete this user:")
            ->expectsQuestion("Do you really want to delete this user (irreversible)?", false)
            ->assertExitCode(2)
            ->run();

        $this->assertDatabaseHas('users', ['email' => "john@testing"]);
    }

    public function testForce() {
        $this->artisan('user:remove john@testing --force')
            ->expectsOutput("You are about to delete this user:")
            ->assertExitCode(0)
            ->run();

        $this->assertDatabaseMissing('users', ['email' => "john@testing"]);
    }
}
