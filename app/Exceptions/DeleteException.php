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

use Exception;
use Throwable;

/**
 * Class UpdateException.
 */
class DeleteException extends Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @see https://php.net/manual/en/exception.construct.php
     *
     * @param string $message [optional] The Exception message to throw
     * @param throwable $previous [optional] The previous throwable used for the exception chaining
     *
     * @since 5.1
     */
    public function __construct(string $message = "Could not delete resource.", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
