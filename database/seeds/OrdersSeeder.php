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
        factory(App\Order::class, 10)->create()->each(function ($order) {
            $order->products()->saveMany(factory(\App\Product::class, 3)->create());
        });
    }
}
