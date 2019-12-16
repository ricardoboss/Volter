<?php

declare(strict_types=1);

use App\Models\Password;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class PasswordSeeder.
 */
class PasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Password::class, 50)->make()->each(function (Password $password) {
            $password->creator()->associate(User::all()->random());
            $password->save();
        });
    }
}
