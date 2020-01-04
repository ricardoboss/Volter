<?php
declare(strict_types=1);

/*
 * Copyright (C) 2019 Ricardo Boss
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

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

    final private function registerMacros(): void
    {
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
