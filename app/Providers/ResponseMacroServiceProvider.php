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
