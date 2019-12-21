<?php

/** @var Factory $factory */
use App\Models\Password;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Password::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
        'version' => $faker->numberBetween(0, 100),
        'notes' => $faker->boolean ? $faker->text : '',
        'value' => encrypt($faker->word . $faker->numberBetween(0, 9999)),
    ];
});
