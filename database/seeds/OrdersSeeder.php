<?php

use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Product::all();

        factory(App\Order::class, 10)->create()->each(function ($order) use ($products) {
            $order->products()->saveMany($products->random(3));
        });
    }
}
