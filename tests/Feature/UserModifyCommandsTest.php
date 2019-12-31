<?php

namespace Tests\Feature;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $this->user = factory(User::class)->create([
            'name' => "John Doe",
            'email' => "test@example.com",
            'password' => Hash::make('password')
        ]);
    }

    public function testInteractiveWithId(): void
    {
        $this->withInteractiveInput($this->user->id, "email", "john@example.com");
    }

    public function testStaticWithId(): void
    {
        $this->withStaticInput($this->user->id, "email", "john@example.com");
    }

    public function testInteractiveWithEmail(): void
    {
        $this->withInteractiveInput($this->user->email, "name", "Jane Doe");
    }

    public function testStaticWithEmail(): void
    {
        $this->withStaticInput($this->user->email, "name", "Jane Doe");
    }

    public function testInteractiveWithName(): void
    {
        $this->withInteractiveInput($this->user->name, "email", "john@example.com");
    }

    public function testStaticWithName(): void
    {
        $this->withStaticInput($this->user->name, "email", "john@example.com");
    }

    private function withInteractiveInput(string $filter, string $attr, string $value): void
    {
        $this->artisan("user:mod $filter")
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
            ->expectsOutput("User saved:")
            ->assertExitCode(0);

        $this->user->refresh();

        $this->assertEquals($value, $this->user->{$attr});
    }
}
