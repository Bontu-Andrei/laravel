<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->name,
        'customer_details' => $faker->sentence,
        'customer_comments' => $faker->paragraph,
        'creation_date' => $faker->date(),
        'product_price_sum' =>$faker->numerify(),
    ];
});
