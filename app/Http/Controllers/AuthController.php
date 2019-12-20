<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;

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
                'refresh',
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
            throw new AuthenticationException();
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
     */
    public function refresh(): array
    {
        return response()->access_token(auth()->refresh());
    }
}
