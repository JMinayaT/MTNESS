<?php

use Faker\Generator as Faker;
use  Modules\Auth\Models\User;

$factory->define(User::class, function(Faker $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'active' => $faker->randomElement([true,false]),
        'remember_token' => str_random(10),
    ];
});
