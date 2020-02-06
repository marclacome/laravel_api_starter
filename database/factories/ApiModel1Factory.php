<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\ApiModel1::class, function (Faker $faker) {
    return [
        'email' => $faker->email(),
        'fname' => $faker->firstName(),
        'lname' => $faker->lastName(),
        'town' => $faker->city(),
    ];
});
