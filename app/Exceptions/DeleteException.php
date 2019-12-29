<?php
declare(strict_types=1);

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
