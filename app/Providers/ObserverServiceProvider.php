<?php
declare(strict_types=1);

namespace App\Providers;

use App\Models\Password;
use App\Observers\PasswordObserver;
use Illuminate\Support\ServiceProvider;

/**
 * Class ObserverServiceProvider
 * @package App\Providers
 */
class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Password::observe(PasswordObserver::class);
    }
}
