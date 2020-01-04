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
                'message' => "Invalid credentials.",
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
                    'expires_at',
                ],
            ])
            ->assertJsonPath('data.token_type', 'bearer', true);

        $expiry_time = $response->json('data.expires_at');

        $this->assertGreaterThan(Carbon::now()->unix(), $expiry_time);
    }
}
