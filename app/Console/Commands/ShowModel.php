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

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait PrintModel.
 *
 * @mixin Command
 */
trait ShowModel
{
    /**
     * Print a table with only the headers and one row containing the given attributes.
     *
     * @noinspection PhpDocSignatureInspection
     */
    public function show(Model $model, array $attributes): void
    {
        $this->table($attributes, [$model->only($attributes)]);
    }
}
