<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'rating' => $faker->numberBetween(1, 5),
        'description' => $faker->paragraph,
    ];
});
