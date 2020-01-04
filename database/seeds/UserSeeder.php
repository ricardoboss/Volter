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

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (
            env('SEED_NAME') != null &&
            env('SEED_PASS') != null &&
            env('SEED_MAIL') != null &&
            !DB::table('users')->where(['email' => env('SEED_MAIL')])->exists()
        ) {
            factory(User::class)->create([
                'name' => env('SEED_NAME'),
                'email' => env('SEED_MAIL'),
                'password' => bcrypt(env('SEED_PASS')),
                'email_verified_at' => Carbon::now(),
            ]);
        }

        factory(User::class, 20)->create();
    }
}
