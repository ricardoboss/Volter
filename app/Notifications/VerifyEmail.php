<?php
declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as Notification;

/**
 * Class VerifyEmail
 */
class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;
}
