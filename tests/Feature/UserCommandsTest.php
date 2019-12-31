<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCommandsTest extends TestCase
{
    public function testUserAddCommand(): void
    {
        $this->artisan('user:add')
            ->expectsQuestion('Name', 'John Doe')
            ->expectsQuestion('E-Mail Address', 'test@example.com')
            ->expectsQuestion('Password (hidden)', 'password')
            ->expectsOutput('User created with role \'User\':')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        $user = User::whereEmail('test@example.com')->first();

        $this->assertTrue($user->hasRole('user'));
    }
}
