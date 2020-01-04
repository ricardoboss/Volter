<?php

declare(strict_types=1);

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

namespace App\Http\Controllers;

use App\Exceptions\TokenRefreshException;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * Class AuthController.
 */
class AuthController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')
            ->only([
                'logout',
                'me',
            ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @throws AuthenticationException
     */
    public function login(): array
    {
        $credentials = request(['email', 'password']);

        /** @var false|string $token */
        $token = auth()->attempt($credentials);

        if (!$token) {
            throw new AuthenticationException("Invalid credentials.");
        }

        return response()->access_token($token);
    }

    /**
     * Log the current user out.
     */
    public function logout(): void
    {
        auth()->logout();
    }

    /**
     * Get the currently authenticated user.
     */
    public function me(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * Refresh a token.
     *
     * @throws TokenRefreshException if the token cannot be refreshed
     */
    public function refresh(): array
    {
        try {
            // refresh the token sent by the user
            $token = auth()->refresh();

            // send it as the new access token
            return response()->access_token($token);
        } catch (TokenInvalidException | JWTException $e) {
            throw new TokenRefreshException('Provided token cannot be refreshed.', $e);
        }
    }
}
