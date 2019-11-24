<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public final function createApplication(): Application
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        assert($app instanceof Application);

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
