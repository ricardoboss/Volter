<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

/**
 * Class ResourceServiceProvider
 * @package App\Providers
 */
class ResourceServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();
    }
}
