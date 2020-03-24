<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'rating' => $faker->numberBetween(1, 5),
        'description' => $faker->paragraph,
        'product_id' => function () {
            // we need to do like this with func because it is called after we check if override value was passed
            return factory(\App\Product::class)->create()->id;
        },
    ];
});
