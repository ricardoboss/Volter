<?php
declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\User\Add;
use App\Console\Commands\User\Modify;
use App\Console\Commands\User\Remove;
use App\Console\Commands\Verify;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Add::class,
        Modify::class,
        Remove::class,
        Verify::class,
    ];

    /**
     * Define the application's command schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        $schedule->call(function (): void {
        })->weekdays()->dailyAt('10:00');
    }

    /**
     * Register the commands for the application.
     */
    public function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        /** @noinspection PhpIncludeInspection */
        require base_path('routes/console.php');
    }
}
