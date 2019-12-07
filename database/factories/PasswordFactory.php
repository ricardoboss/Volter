<?php

/** @var Factory $factory */

use App\Models\Password;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Password::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
        'notes' => $faker->boolean ? $faker->text : "",
        'value' => encrypt($faker->word),
    ];
});
