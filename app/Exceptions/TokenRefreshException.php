<?php
declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Class TokenRefreshException
 *
 * @package App\Exceptions
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
