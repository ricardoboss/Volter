<?php

use App\Models\Password;
use App\Models\User;
use Illuminate\Database\Seeder;

class PasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Password::class, 50)->create()->each(function (Password $password) {
            $password->creator()->associate(User::all()->random());
        });
    }
}
