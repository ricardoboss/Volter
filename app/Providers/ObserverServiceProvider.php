<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Password;
use App\Models\User;
use App\Observers\PasswordObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

/**
 * Class ObserverServiceProvider.
 */
class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Password::observe(PasswordObserver::class);
        User::observe(UserObserver::class);
    }
}
