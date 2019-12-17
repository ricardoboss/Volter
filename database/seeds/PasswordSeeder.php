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
     */
    public function run(): void
    {
        factory(Password::class, 50)->make()->each(function (Password $password): void {
            $password->creator()->associate(User::all()->random());
            $password->save();
        });
    }
}
