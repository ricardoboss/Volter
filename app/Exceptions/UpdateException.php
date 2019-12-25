<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class UpdateException.
 */
class UpdateException extends Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @see https://php.net/manual/en/exception.construct.php
     *
     * @param string $message [optional] The Exception message to throw
     * @param int $code [optional] The Exception code
     * @param throwable $previous [optional] The previous throwable used for the exception chaining
     *
     * @since 5.1
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
