<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testInvalidCredentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => "invalid@email.com",
            'password' => "wrong",
        ]);

        $response->assertUnauthorized()
            ->assertApiResponse(false)
            ->assertJsonFragment([
                'message' => "Invalid credentials."
            ]);
    }

    public function testValidCredentials(): void
    {
        factory(User::class)->create([
            'email' => "john@testing",
            'password' => Hash::make("test"),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => "john@testing",
            'password' => "test",
        ]);

        $response->assertOk()
            ->assertApiResponse()
            ->assertJsonStructure([
                'data' => [
                    'token_type',
                    'access_token',
                    'expires_at'
                ]
            ])
            ->assertJsonPath('data.token_type', 'bearer', true);

        $expiry_time = $response->json('data.expires_at');

        $this->assertGreaterThan(Carbon::now()->unix(), $expiry_time);
    }
}
