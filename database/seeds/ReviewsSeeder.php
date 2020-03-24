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
        $product = factory(\App\Product::class)->create();

        factory(App\Review::class, 5)->create([
            'product_id' => $product->id,
        ]);
    }
}
