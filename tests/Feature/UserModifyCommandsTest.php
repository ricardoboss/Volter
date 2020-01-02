<?php

namespace Tests\Feature;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModifyCommandsTest extends TestCase
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
