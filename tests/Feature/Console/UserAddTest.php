<?php

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
