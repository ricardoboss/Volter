<?php
declare(strict_types=1);

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * Class ApiErrorCodes
 *
 * @package App\Enums
 *
 * @method static self unauthorized()
 * @method static self invalid_credentials()
 * @method static self delete_failed()
 */
class ApiErrorCode extends Enum
{
}
