<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ApiErrorCodes;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController
 * @package App\Http\Controllers
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
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        /** @var string|bool $token */
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->failed(
                ApiErrorCodes::invalidCredentials(),
                ["Invalid login credentials."],
                401
            );
        }

        return response()->access_token($token);
    }

    /**
     * Log the current user out.
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->success(true, ["Logout successful."]);
    }

    /**
     * Get the currently authenticated user.
     */
    public function me(): JsonResponse
    {
        return response()->success(auth()->user());
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return response()->access_token(auth()->refresh());
    }
}
