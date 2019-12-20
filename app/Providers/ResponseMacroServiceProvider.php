<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

/**
 * Class ResponseMacroServiceProvider.
 */
class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /*
         * Returns an array with an api access token.
         *
         * @param string $token The access token to include in the response.
         * @return array
         */
        Response::macro('access_token', function (string $token) {
            /** @noinspection PhpUndefinedMethodInspection */
            // TTL can be infinite (null).
            // CAUTION! Tokens must not have the 'exp' claim if TTL is set to null!
            $ttl = auth()->factory()->getTTL();

            return [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_at' => $ttl != null ? now()->addMinutes($ttl)->timestamp : null,
            ];
        });
    }
}
