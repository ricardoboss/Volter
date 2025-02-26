<?php

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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePasswordValueToRawValue extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('passwords', function (Blueprint $table): void {
            $table->renameColumn('value', 'raw_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passwords', function (Blueprint $table): void {
            $table->renameColumn('raw_value', 'value');
        });
    }
}
