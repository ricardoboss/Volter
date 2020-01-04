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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

if (!function_exists('get_table_cols')) {
    /**
     * Get model attributes from database columns.
     *
     * @return array|null
     */
    function get_table_cols(string $modelClass): ?array
    {
        /** @var Model $m */
        $m = new $modelClass();

        return Schema::getColumnListing($m->getTable());
    }
}

if (!function_exists('get_model_attrs')) {
    /**
     * Get model attributes from database columns.
     *
     * @return array|null
     */
    function get_model_attrs(string $modelClass): ?array
    {
        /** @var Model $m */
        $m = new $modelClass();

        return $m->getFillable();
    }
}
