<?php
declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestResponse;

/**
 * Trait CreatesApplication.
 */
trait CreatesApplication
{
    /**
     * Creates the application.
     */
    final public function createApplication(): Application
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        assert($app instanceof Application);

        $app->make(Kernel::class)->bootstrap();

        $this->registerMacros();

        return $app;
    }

    private final function registerMacros() {
        TestResponse::macro('assertApiResponse', function (bool $success = true) {
            /** @var TestResponse $this */
            $this->assertJsonStructure([
                'success',
                'data',
            ]);

            /** @var TestResponse $this */
            return $this->assertJsonPath('success', $success, true);
        });
    }
}
