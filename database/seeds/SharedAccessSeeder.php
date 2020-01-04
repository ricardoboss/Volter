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

use App\Models\Password;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class SharedAccessSeeder.
 */
class SharedAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwords = Password::all();
        $users = User::all();

        $accesses = [];
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $password = $passwords->where('created_by', '!=', $user->id)->random();

            $accesses[] = [
                'password_id' => $password->id,
                'model_type' => User::class,
                'model_id' => $user->id,
                'key' => Str::random(12),
                'can_edit' => rand() > 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('shared_access')->insertOrIgnore($accesses);
    }
}
