<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Unauthorized()
 */
final class ApiErrorCodes extends Enum
{
    const Unauthorized = 0;
    const InvalidCredentials = 1;
}
