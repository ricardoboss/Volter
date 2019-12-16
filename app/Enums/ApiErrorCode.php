<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * Class ApiErrorCodes.
 *
 *
 * @method static self unauthorized()
 * @method static self unauthenticated()
 * @method static self delete_failed()
 * @method static self not_found()
 * @method static self too_many_requests()
 * @method static self server_error()
 * @method static self exception()
 */
class ApiErrorCode extends Enum
{
}
