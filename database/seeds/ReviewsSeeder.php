<?php

use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Product::all()->each(function ($product) {
            $product->reviews()->saveMany(factory(\App\Review::class, 5)->make());
        });

        \App\Order::all()->each(function ($order) {
            $order->reviews()->saveMany(factory(\App\Review::class, 5)->make());
        });
    }
}
