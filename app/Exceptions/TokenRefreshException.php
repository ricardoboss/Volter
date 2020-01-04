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

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Class TokenRefreshException.
 */
class TokenRefreshException extends HttpException
{
    /**
     * Create a new authentication exception.
     */
    public function __construct(string $message = 'Provided token cannot be refreshed.', Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, $message, $previous, $headers, $code);
    }
}
