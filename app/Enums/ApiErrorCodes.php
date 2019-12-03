<?php
declare(strict_types=1);

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * Class ApiErrorCodes
 *
 * @package App\Enums
 */
class ApiErrorCodes extends Enum
{
    /**
     * @return ApiErrorCodes
     */
    public static function unauthorized(): ApiErrorCodes
    {
        return new class() extends ApiErrorCodes {
            /**
             * Get the current value.
             *
             * @return string
             */
            public function getValue(): string
            {
                return "api.error.unauthorized";
            }
        };
    }

    /**
     * @return ApiErrorCodes
     */
    public static function invalidCredentials(): ApiErrorCodes
    {
        return new class() extends ApiErrorCodes {
            /**
             * Get the current value.
             *
             * @return string
             */
            public function getValue(): string
            {
                return "api.error.invalid_credentials";
            }
        };
    }
}
