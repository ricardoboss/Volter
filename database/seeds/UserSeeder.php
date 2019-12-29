<?php

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
