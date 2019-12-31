<?php
declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class VerifyEmail.
 */
class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;
}
