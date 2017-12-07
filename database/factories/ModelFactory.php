<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Review::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'message' => $faker->realText,
        'status' => rand(0, 1)
    ];
});

$factory->define(App\Models\News::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
        'sysname' => 'some-furl-'.rand(0, 9999),
        'body' => $faker->text,
        'title' => $faker->sentence,
        'keywords' => $faker->words(10, true),
        'description' => $faker->sentences(2, true),
        'status' => rand(0, 1)
    ];
});
